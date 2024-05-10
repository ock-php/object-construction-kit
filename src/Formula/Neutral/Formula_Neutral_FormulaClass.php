<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Neutral;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Exception\FormulaException;
use Donquixote\Ock\Formula\FreeParameters\Formula_FreeParameters;

class Formula_Neutral_FormulaClass extends Formula_Passthru_ProxyBase {

  /**
   * Constructor.
   *
   * @param class-string<FormulaInterface> $class
   * @param array $args
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
