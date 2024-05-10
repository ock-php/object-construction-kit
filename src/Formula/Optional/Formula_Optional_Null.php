<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Optional;

use Donquixote\Ock\Text\TextInterface;

class Formula_Optional_Null extends Formula_OptionalBase {

  /**
   * {@inheritdoc}
   */
  public function getEmptySummary(): ?TextInterface {
    return NULL;
  }

  /**
   * @return string
   *   Typically 'NULL'.
   */
  final public function getEmptyPhp(): string {
    return 'NULL';
  }

}
