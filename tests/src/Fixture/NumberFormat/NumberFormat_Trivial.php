<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Fixture\NumberFormat;

use Ock\Ock\Attribute\Plugin\OckPluginInstance;

/**
 * Adapter from NumberFormat to IntFormat.
 */
#[OckPluginInstance('trivial', 'Trivial - print number as-is')]
class NumberFormat_Trivial implements NumberFormatInterface {

  /**
   * {@inheritdoc}
   */
  public function format(int|float $number): string {
    return (string) $number;
  }

}
