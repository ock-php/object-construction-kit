<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\ValueProvider;

use Ock\CodegenTools\Util\PhpUtil;

class Formula_FixedPhp_Adaptee implements Formula_FixedPhpInterface {

  /**
   * {@inheritdoc}
   */
  public function getPhp(): string {
    return PhpUtil::phpPlaceholderAdaptee();
  }

}
