<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\Group;

use Donquixote\CodegenTools\Util\CodeGen;

class V2V_Group_Trivial implements V2V_GroupInterface {

  /**
   * {@inheritdoc}
   * @param array $conf
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
    return CodeGen::phpArray($itemsPhp);
  }

}
