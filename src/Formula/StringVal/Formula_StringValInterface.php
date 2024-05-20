<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\StringVal;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Ock\Ock\V2V\String\V2V_StringInterface;

interface Formula_StringValInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Ock\Ock\Formula\Textfield\Formula_TextfieldInterface
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return \Ock\Ock\V2V\String\V2V_StringInterface
   */
  public function getV2V(): V2V_StringInterface;

}
