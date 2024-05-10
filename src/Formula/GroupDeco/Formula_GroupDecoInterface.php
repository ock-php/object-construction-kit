<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\GroupDeco;

use Donquixote\Ock\Formula\Group\Formula_GroupInterface;
use Donquixote\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Donquixote\Ock\V2V\Group\V2V_GroupInterface;

interface Formula_GroupDecoInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Donquixote\Ock\Formula\Group\Formula_GroupInterface
   */
  public function getDecorated(): Formula_GroupInterface;

  /**
   * @param string $php
   *   PHP to be decorated.
   *
   * @return \Donquixote\Ock\V2V\Group\V2V_GroupInterface
   */
  public function phpGetV2V(string $php): V2V_GroupInterface;

}
