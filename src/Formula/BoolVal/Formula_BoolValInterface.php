<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\BoolVal;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Donquixote\Ock\V2V\Boolean\V2V_BooleanInterface;

interface Formula_BoolValInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Donquixote\Ock\Formula\Boolean\Formula_BooleanInterface
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return \Donquixote\Ock\V2V\Boolean\V2V_BooleanInterface
   */
  public function getV2V(): V2V_BooleanInterface;

}
