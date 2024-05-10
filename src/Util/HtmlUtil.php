<?php

declare(strict_types=1);

namespace Donquixote\Ock\Util;

class HtmlUtil {

  /**
   * @param object|string $text
   *
   * @return string
   */
  public static function sanitize(object|string $text): string {
    return is_string($text)
      ? htmlspecialchars($text, ENT_QUOTES)
      : (string) $text;
  }

}
