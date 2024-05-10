<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests\Fixture\IntFormat;

/**
 * Formats a number as a string.
 */
interface IntFormatInterface {

  /**
   * Formats a number as a string.
   *
   * @param int $number
   *   Integer number.
   *
   * @return string
   *   Formatted string.
   */
  public function format(int $number): string;

}
