<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Neutral;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Exception\FormulaException;
use Donquixote\Ock\Formula\FreeParameters\Formula_FreeParameters;

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
