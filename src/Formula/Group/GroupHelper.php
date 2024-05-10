<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Group;

use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Evaluator\Evaluator;
use Donquixote\Ock\Exception\EvaluatorException;
use Donquixote\Ock\Exception\FormulaException;
use Donquixote\Ock\Formula\Group\Item\GroupFormulaItemInterface;
use Donquixote\Ock\FormulaAdapter;
use Donquixote\Ock\Text\TextInterface;

class GroupHelper {

  /**
   * @var \Donquixote\Ock\Formula\Group\Item\GroupFormulaItemInterface[]
   */
  private array $originalItems = [];

  /**
   * @var array<array-key, array-key>
   */
  private array $keys = [];

  /**
   * @var int[]
   */
  private array $itemPositions;

  /**
   * @var array
   */
  private array $groupConf = [];

  /**
   * @var mixed[]
   */
  private array $resolvedValues = [];

  /**
   * @var TextInterface[]
   */
  private array $labels = [];

  /**
   * @var FormulaInterface[]
   */
  private array $formulas = [];

  /**
   * @var array[]
   */
  private array $argss;

  /**
   * Constructor.
   *
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $adapter
   */
  public function __construct(
    private readonly UniversalAdapterInterface $adapter,
  ) {}

  /**
   * @param \Donquixote\Ock\Formula\Group\Item\GroupFormulaItemInterface[] $originalItems
   *
   * @return static
   */
  public function withOriginalItems(array $originalItems): static {
    $clone = clone $this;
    $clone->reset();
    $clone->originalItems = $originalItems;
    $keys = array_keys($originalItems);
    $clone->keys = array_combine($keys, $keys);
    $clone->itemPositions = array_flip($keys);
    $clone->groupConf = [];
    return $clone;
  }

  /**
   * @param array $groupConf
   *
   * @return static
   */
  public function withConf(array $groupConf): static {
    $clone = clone $this;
    $clone->reset();
    $clone->groupConf = $groupConf;
    return $clone;
  }

  /**
   * Clears all mutable values.
   */
  private function reset(): void {
    $this->resolvedValues = [];
    $this->argss = [];
    $this->labels = [];
    $this->formulas = [];
  }

  /**
   * @return string[]
   */
  public function getKeys(): array {
    return $this->keys;
  }

  /**
   * @param string|int $key
   *
   * @return \Donquixote\Ock\Formula\Group\Item\GroupFormulaItemInterface
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  private function keyGetOriginalItem(string|int $key): GroupFormulaItemInterface {
    if (NULL === $originalItem = $this->originalItems[$key] ?? NULL) {
      throw new FormulaException(sprintf('Unknown key %s', $key));
    }
    return $originalItem;
  }

  /**
   * @template T as object
   *
   * @param class-string<T> $interface
   *
   * @return T[]
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  public function getObjects(string $interface): array {
    $objects = [];
    foreach ($this->getKeys() as $key) {
      $objects[$key] = $this->keyGetObject($key, $interface);
    }
    return $objects;
  }

  /**
   * @template T
   *
   * @param string|int $key
   * @param class-string<T> $interface
   *
   * @return T
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  public function keyGetObject(string|int $key, string $interface): object {
    return FormulaAdapter::requireObject(
      $this->keyGetFormula($key),
      $interface,
      $this->adapter,
    );
  }

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface[]
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  public function getFormulas(): array {
    $formulas = [];
    foreach ($this->keys as $key) {
      $formulas[$key] = $this->keyGetFormula($key);
    }
    return $formulas;
  }

  /**
   * @param string|int $key
   *
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  public function keyGetFormula(string|int $key): FormulaInterface {
    return $this->formulas[$key]
      ??= $this->keyGetOriginalItem($key)
      ->getFormula($this->keyGetArgs($key));
  }

  /**
   * @param string|int $key
   *
   * @return \Donquixote\Ock\Text\TextInterface
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  public function keyGetLabel(string|int $key): TextInterface {
    return $this->labels[$key]
      ??= $this->keyGetOriginalItem($key)
      ->getLabel($this->keyGetArgs($key));
  }

  /**
   * @param string|int $key
   *
   * @return array
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  private function keyGetArgs(string|int $key): array {
    if (NULL === $args =& $this->argss[$key]) {
      $args = [];
      foreach ($this->keyGetOriginalItem($key)->dependsOnKeys() as $k => $dependsOnKey) {
        if ($this->itemPositions[$dependsOnKey] > $this->itemPositions[$key]) {
          throw new FormulaException(sprintf('Forward dependency to %s from %s.', $dependsOnKey, $key));
        }
        $args[$k] = $this->keyGetValue($dependsOnKey);
      }
    }
    return $args;
  }

  /**
   * @param string|int $key
   *
   * @return mixed
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  private function keyGetValue(string|int $key): mixed {
    if (!array_key_exists($key, $this->resolvedValues)) {
      $formula = $this->keyGetFormula($key);
      try {
        $evaluator = Evaluator::fromFormula($formula, $this->adapter);
      }
      catch (AdapterException $e) {
        throw new FormulaException(sprintf('Cannot get evaluator for formula in item %s.', $key), 0, $e);
      }
      try {
        $this->resolvedValues[$key] = $evaluator->confGetValue($this->groupConf[$key] ?? NULL);
      }
      catch (EvaluatorException $e) {
        throw new FormulaException(sprintf('Cannot evaluate item %s.', $key), 0, $e);
      }
    }
    return $this->resolvedValues[$key];
  }

}
