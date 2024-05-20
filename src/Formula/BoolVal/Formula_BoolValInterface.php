<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\BoolVal;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Ock\Ock\V2V\Boolean\V2V_BooleanInterface;

interface Formula_BoolValInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Ock\Ock\Formula\Boolean\Formula_BooleanInterface
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return \Ock\Ock\V2V\Boolean\V2V_BooleanInterface
   */
  public function getV2V(): V2V_BooleanInterface;

}
