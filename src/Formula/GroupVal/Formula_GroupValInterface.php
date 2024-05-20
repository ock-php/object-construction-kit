<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\GroupVal;

use Ock\Ock\Formula\Group\Formula_GroupInterface;
use Ock\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Ock\Ock\V2V\Group\V2V_GroupInterface;

interface Formula_GroupValInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Ock\Ock\Formula\Group\Formula_GroupInterface
   */
  public function getDecorated(): Formula_GroupInterface;

  /**
   * @return \Ock\Ock\V2V\Group\V2V_GroupInterface
   */
  public function getV2V(): V2V_GroupInterface;

}
