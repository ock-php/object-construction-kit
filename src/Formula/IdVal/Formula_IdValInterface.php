<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\IdVal;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Donquixote\Ock\V2V\Id\V2V_IdInterface;

interface Formula_IdValInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Donquixote\Ock\Formula\Id\Formula_IdInterface
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return \Donquixote\Ock\V2V\Id\V2V_IdInterface
   */
  public function getV2V(): V2V_IdInterface;

}
