<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\ValueProvider;

class Formula_FixedPhp_Null implements Formula_FixedPhpInterface {

  /**
   * {@inheritdoc}
   */
  public function getPhp(): string {
    return 'NULL';
  }

}
