<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Neutral;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Exception\FormulaException;
use Ock\Ock\Formula\FreeParameters\Formula_FreeParameters;

class Formula_Passthru_FormulaFactory extends Formula_Passthru_ProxyBase {

  /**
   * Constructor.
   *
   * @param callable(mixed...): FormulaInterface $factory
   * @param array $args
   */
  public function __construct(
    private readonly mixed $factory,
    private readonly array $args = [],
  ) {}

  /**
   * {@inheritdoc}
   */
  protected function doGetDecorated(): FormulaInterface {
    try {
      return Formula_FreeParameters::fromFormulaCallback($this->factory, $this->args);
    }
    catch (\ReflectionException $e) {
      throw new FormulaException('Cannot create formula for factory.', 0, $e);
    }
  }

}
