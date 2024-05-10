<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\StringVal;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Donquixote\Ock\V2V\String\V2V_StringInterface;

interface Formula_StringValInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Donquixote\Ock\Formula\Textfield\Formula_TextfieldInterface
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return \Donquixote\Ock\V2V\String\V2V_StringInterface
   */
  public function getV2V(): V2V_StringInterface;

}
