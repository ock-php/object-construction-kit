<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\ValueProvider;

use Donquixote\CodegenTools\Util\PhpUtil;

class Formula_FixedPhp_Decorated implements Formula_FixedPhpInterface {

  /**
   * {@inheritdoc}
   */
  public function getPhp(): string {
    return PhpUtil::phpPlaceholderDecorated();
  }

}
