<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\String;

final class V2V_String_Trivial implements V2V_StringInterface {

  /**
   * {@inheritdoc}
   */
  public function stringGetPhp(string $string): string {
    return var_export($string, TRUE);
  }

}
