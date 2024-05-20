<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Group;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Exception\FormulaException;
use Ock\Ock\Exception\GroupFormulaDuplicateKeyException;
use Ock\Ock\Formula\Formula;
use Ock\Ock\Formula\Group\Item\GroupFormulaItem;
use Ock\Ock\Formula\Group\Item\GroupFormulaItem_Callback;
use Ock\Ock\Formula\Group\Item\GroupFormulaItemInterface;
use Ock\Ock\Formula\Optionless\Formula_OptionlessInterface;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;
use Ock\Ock\V2V\Group\V2V_GroupInterface;

class GroupFormulaBuilder extends GroupValFormulaBuilderBase {

  /**
   * @var \Ock\Ock\Formula\Group\Item\GroupFormulaItemInterface[]
   */
  private array $items = [];

  /**
   * Adds another group option.
   *
   * @param string $key
   * @param \Ock\Ock\Text\TextInterface $label
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   *
   * @return $this
   *
   * @throws \Ock\Ock\Exception\GroupFormulaDuplicateKeyException
   */
  public function add(string $key, TextInterface $label, FormulaInterface $formula): static {
    return $this->addItem($key, new GroupFormulaItem($label, $formula));
  }

  /**
   * @param string|int $key
   * @param \Ock\Ock\Formula\Group\Item\GroupFormulaItemInterface $item
   *
   * @return $this
   *
   * @throws \Ock\Ock\Exception\GroupFormulaDuplicateKeyException
   *   A key already exists.
   */
  private function addItem(string|int $key, GroupFormulaItemInterface $item): static {
    if (isset($this->items[$key])) {
      throw new GroupFormulaDuplicateKeyException("Key '$key' already exists.");
    }
    $this->items[$key] = $item;
    return $this;
  }

  /**
   * Adds an optionless group option.
   *
   * @param string $key
   * @param \Ock\Ock\Formula\Optionless\Formula_OptionlessInterface $formula
   *
   * @return $this
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addOptionless(string $key, Formula_OptionlessInterface $formula): static {
    // @todo Option to not add a label for optionless options?
    return $this->add($key, Text::s($key), $formula);
  }

  /**
   * @param string $key
   * @param \Ock\Ock\Text\TextInterface|(callable(mixed...): TextInterface) $label
   * @param list<string> $sourceKeys
   * @param callable(mixed...): \Ock\Ock\Core\Formula\FormulaInterface $callback
   *
   * @return $this
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addDynamicFormula(string $key, TextInterface|callable $label, array $sourceKeys, callable $callback): static {
    return $this->addItem($key, new GroupFormulaItem_Callback(
      $sourceKeys,
      $label,
      $callback,
    ));
  }

  /**
   * @param string $key
   * @param list<string> $sourceKeys
   * @param callable(mixed...): mixed $valueCallback
   *
   * @return $this
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addDynamicValue(string $key, array $sourceKeys, callable $valueCallback): static {
    return $this->addItem($key, new GroupFormulaItem_Callback(
      $sourceKeys,
      Text::s($key),
      fn (mixed... $args) => Formula::value($valueCallback(...$args)),
    ));
  }

  /**
   * @param list<string> $keys
   * @param list<string> $sourceKeys
   * @param callable(mixed...): array $multipleValueCallback
   *
   * @return $this
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addDynamicValues(array $keys, array $sourceKeys, callable $multipleValueCallback): static {
    foreach ($keys as $i => $key) {
      $this->addItem($key, new GroupFormulaItem_Callback(
        $sourceKeys,
        Text::s($key),
        fn (mixed... $args) => Formula::value($multipleValueCallback(...$args)[$i]),
      ));
    }
    return $this;
  }

  /**
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addStringParts(array $keys, string $glue, string $sourceKey): static {
    foreach ($keys as $i => $key) {
      $this->addItem($key, new GroupFormulaItem_Callback(
        [$sourceKey],
        Text::s($key),
        fn (string $source) => Formula::value(
          explode($glue, $source)[$i],
        ),
      ));
    }
    return $this;
  }

  /**
   * Adds matches from a regular expression.
   *
   * @param string[] $keys
   *   Keys for the new values.
   * @param string $regex
   *   Regular expression pattern.
   * @param string $sourceKey
   *   Key with the source string.
   *
   * @return $this
   *
   * @throws \Ock\Ock\Exception\FormulaException
   *   Item cannot be added, possibly due to a key collision.
   *
   * @noinspection PhpVoidFunctionResultUsedInspection
   */
  public function addRegexMatch(array $keys, string $regex, string $sourceKey): static {
    foreach ($keys as $i => $key) {
      $this->addItem($key, new GroupFormulaItem_Callback(
        [$sourceKey],
        Text::s($key),
        fn (string $source) => Formula::value(
          preg_match($regex, $source, $m)
            ? $m[$i]
            : self::fail(sprintf("String '%s' does not match '%s'.", $source, $regex)),
        ),
      ));
    }
    return $this;
  }

  /**
   * @return \Ock\Ock\Formula\Group\Formula_Group
   */
  public function buildGroupFormula(): Formula_Group {
    return new Formula_Group($this->items);
  }

  /**
   * {@inheritdoc}
   */
  protected function doAddExpression(string $key, V2V_GroupInterface $v2v): GroupValFormulaBuilder {
    return (new GroupValFormulaBuilder($this->buildGroupFormula()))
      ->doAddExpression($key, $v2v);
  }

  /**
   * {@inheritdoc}
   */
  protected function decorateV2V(?V2V_GroupInterface $v2v): ?V2V_GroupInterface {
    return $v2v;
  }

  /**
   * {@inheritdoc}
   */
  protected function getGroupFormula(): Formula_Group {
    return $this->buildGroupFormula();
  }

  /**
   * @param string $message
   *
   * @return never
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  private static function fail(string $message): never {
    throw new FormulaException($message);
  }

}
