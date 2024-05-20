<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\GroupDeco;

use Ock\Ock\Formula\Group\Formula_GroupInterface;
use Ock\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Ock\Ock\V2V\Group\V2V_GroupInterface;

interface Formula_GroupDecoInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Ock\Ock\Formula\Group\Formula_GroupInterface
   */
  public function getDecorated(): Formula_GroupInterface;

  /**
   * @param string $php
   *   PHP to be decorated.
   *
   * @return \Ock\Ock\V2V\Group\V2V_GroupInterface
   */
  public function phpGetV2V(string $php): V2V_GroupInterface;

}
