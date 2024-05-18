<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\Sequence;

use Donquixote\CodegenTools\Util\CodeGen;

class V2V_Sequence_Trivial implements V2V_SequenceInterface {

  /**
   * {@inheritdoc}
   */
  public function itemsPhpGetPhp(array $itemsPhp): string {
    return CodeGen::phpArray($itemsPhp);
  }

}
