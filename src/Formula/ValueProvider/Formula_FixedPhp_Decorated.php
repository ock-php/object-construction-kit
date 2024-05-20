<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\ValueProvider;

use Ock\CodegenTools\Util\PhpUtil;

class Formula_FixedPhp_Decorated implements Formula_FixedPhpInterface {

  /**
   * {@inheritdoc}
   */
  public function getPhp(): string {
    return PhpUtil::phpPlaceholderDecorated();
  }

}
