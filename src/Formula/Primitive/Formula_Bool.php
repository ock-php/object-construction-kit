<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Primitive;

class Formula_Bool implements Formula_ScalarInterface {

  /**
   * {@inheritdoc}
   */
  public function getAllowedTypes(): array {
    return ['bool'];
  }

}
