<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Sequence;

use Ock\CodegenTools\Util\CodeGen;

class V2V_Sequence_Trivial implements V2V_SequenceInterface {

  /**
   * {@inheritdoc}
   */
  public function itemsPhpGetPhp(array $itemsPhp): string {
    return CodeGen::phpArray($itemsPhp);
  }

}
