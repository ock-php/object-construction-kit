<?php

declare(strict_types=1);

namespace Donquixote\Ock\FormulaBase\Decorator;

use Donquixote\Ock\Core\Formula\Base\FormulaBaseInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;

/**
 * @deprecated
 */
interface Formula_DecoratorBaseInterface extends FormulaBaseInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

}
