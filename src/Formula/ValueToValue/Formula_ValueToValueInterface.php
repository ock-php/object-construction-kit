<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\ValueToValue;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Donquixote\Ock\V2V\Value\V2V_ValueInterface;

interface Formula_ValueToValueInterface extends FormulaInterface, Formula_ConfPassthruInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return \Donquixote\Ock\V2V\Value\V2V_ValueInterface
   */
  public function getV2V(): V2V_ValueInterface;

}
