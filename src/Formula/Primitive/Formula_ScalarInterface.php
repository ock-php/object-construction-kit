<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Primitive;

use Ock\Ock\Core\Formula\FormulaInterface;

interface Formula_ScalarInterface extends FormulaInterface {

  /**
   * @return string[]
   */
  public function getAllowedTypes(): array;

}
