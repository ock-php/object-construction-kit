<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\FreeParameters;

use Donquixote\Ock\Core\Formula\FormulaInterface;

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
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function withArgValues(array $args): FormulaInterface;

}
