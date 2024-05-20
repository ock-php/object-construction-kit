<?php

declare(strict_types=1);

namespace Ock\Ock\FormulaBase\Decorator;

use Ock\Ock\Core\Formula\Base\FormulaBaseInterface;
use Ock\Ock\Core\Formula\FormulaInterface;

/**
 * @deprecated
 */
interface Formula_DecoratorBaseInterface extends FormulaBaseInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

}
