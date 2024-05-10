<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\ValueProvider;

use Donquixote\CodegenTools\Util\PhpUtil;

class Formula_FixedPhp_Adaptee implements Formula_FixedPhpInterface {

  /**
   * {@inheritdoc}
   */
  public function getPhp(): string {
    return PhpUtil::phpPlaceholderAdaptee();
  }

}
