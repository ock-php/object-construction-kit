<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests\Fixture\IntFormat;

use Donquixote\Ock\Attribute\Plugin\OckPluginInstance;

/**
 * Adapter from NumberFormat to IntFormat.
 */
#[OckPluginInstance("trivial", "Trivial - print integer as-is")]
class IntFormat_Trivial implements IntFormatInterface {

  /**
   * {@inheritdoc}
   */
  public function format(int $number): string {
    return (string) $number;
  }

}
