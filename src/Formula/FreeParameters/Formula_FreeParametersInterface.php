<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\FreeParameters;

use Ock\Ock\Core\Formula\FormulaInterface;

interface Formula_FreeParametersInterface extends FormulaInterface {

  /**
   * @return \ReflectionParameter[]
   *
   * @throws \ReflectionException
   */
  public function getFreeParameters(): array;

  /**
   * @param mixed[] $args
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function withArgValues(array $args): FormulaInterface;

}
