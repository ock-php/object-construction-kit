<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\GroupVal;

use Donquixote\Ock\Formula\Group\Formula_GroupInterface;
use Donquixote\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Donquixote\Ock\V2V\Group\V2V_GroupInterface;

interface Formula_GroupValInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Donquixote\Ock\Formula\Group\Formula_GroupInterface
   */
  public function getDecorated(): Formula_GroupInterface;

  /**
   * @return \Donquixote\Ock\V2V\Group\V2V_GroupInterface
   */
  public function getV2V(): V2V_GroupInterface;

}
