<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Neutral;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Exception\FormulaException;
use Ock\Ock\Formula\FreeParameters\Formula_FreeParameters;

class Formula_Neutral_FormulaClass extends Formula_Passthru_ProxyBase {

  /**
   * Constructor.
   *
   * @param class-string<FormulaInterface> $class
   * @param mixed[] $args
   */
  public function __construct(
    private readonly string $class,
    private readonly array $args = [],
  ) {}

  /**
   * {@inheritdoc}
   */
  protected function doGetDecorated(): FormulaInterface {
    try {
      return Formula_FreeParameters::fromClass($this->class, $this->args);
    }
    catch (\ReflectionException $e) {
      throw new FormulaException('Cannot create formula for factory.', 0, $e);
    }
  }

}
