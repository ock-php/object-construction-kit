<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\ValueToValue;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Ock\Ock\V2V\Value\V2V_ValueInterface;

interface Formula_ValueToValueInterface extends FormulaInterface, Formula_ConfPassthruInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return \Ock\Ock\V2V\Value\V2V_ValueInterface
   */
  public function getV2V(): V2V_ValueInterface;

}
