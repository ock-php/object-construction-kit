<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\IdVal;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Ock\Ock\V2V\Id\V2V_IdInterface;

interface Formula_IdValInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Ock\Ock\Formula\Id\Formula_IdInterface
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return \Ock\Ock\V2V\Id\V2V_IdInterface
   */
  public function getV2V(): V2V_IdInterface;

}
