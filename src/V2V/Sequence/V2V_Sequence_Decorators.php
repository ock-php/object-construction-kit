<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\Sequence;

use Donquixote\Ock\Util\DecoUtil;

class V2V_Sequence_Decorators implements V2V_SequenceInterface {

  /**
   * {@inheritdoc}
   */
  public function itemsPhpGetPhp(array $itemsPhp): string {
    $php = DecoUtil::PLACEHOLDER;
    foreach ($itemsPhp as $item_php) {
      $php = str_replace(DecoUtil::PLACEHOLDER, $php, $item_php);
    }
    return $php;
  }

}
