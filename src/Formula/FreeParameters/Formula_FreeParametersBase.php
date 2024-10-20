<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\FreeParameters;

use Ock\Ock\Core\Formula\FormulaInterface;

abstract class Formula_FreeParametersBase implements Formula_FreeParametersInterface {

  /**
   * @var array<int, mixed>
   */
  private array $knownArgs = [];

  /**
   * Constructor.
   *
   * @param \ReflectionParameter[] $freeParameters
   */
  public function __construct(
    private array $freeParameters,
  ) {
    if (!array_is_list($freeParameters)) {
      throw new \InvalidArgumentException('Unexpected keys or order in parameter list.');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getFreeParameters(): array {
    return $this->freeParameters;
  }

  /**
   * {@inheritdoc}
   */
  public function withArgValues(array $args): FormulaInterface {
    $clone = clone $this;
    foreach ($args as $index => $value) {
      if (!isset($this->freeParameters[$index])) {
        throw new \RuntimeException("Argument provided for unexpected index '$index'.");
      }
      $clone->knownArgs[$index] = $value;
      unset($clone->freeParameters[$index]);
    }
    ksort($clone->knownArgs);
    return $clone->resolveIfPossible();
  }

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  protected function resolveIfPossible(): FormulaInterface {
    if ($this->freeParameters !== []) {
      return $this;
    }
    $args = $this->knownArgs;
    ksort($args);
    return $this->callArgs($args);
  }

  /**
   * @param mixed[] $args
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  abstract protected function callArgs(array $args): FormulaInterface;

}
