<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Optional;

use Ock\Ock\Text\TextInterface;

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
