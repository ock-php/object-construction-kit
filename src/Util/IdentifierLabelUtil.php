<?php

declare(strict_types=1);

namespace Donquixote\Ock\Util;

use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

/**
 * Helper methods to generate labels from PHP identifiers.
 */
final class IdentifierLabelUtil extends UtilBase {

  public static function fromInterface(string $interface, bool $translate = true): TextInterface {
    if (\str_ends_with($interface, 'Interface')) {
      $interface = substr($interface, 0, -9);
    }
    return self::fromNamespacedIdentifier($interface, $translate);
  }

  public static function fromNamespacedIdentifier(string $identifier, bool $translate = true): TextInterface {
    // Get rid of any namespace parts.
    if (false !== $pos = \strrpos($identifier, '\\')) {
      $identifier = \substr($identifier, $pos);
    }
    return self::fromIdentifier($identifier, $translate);
  }

  public static function fromIdentifier(string $identifier, bool $translate = true): TextInterface {
    return Text::tIf(
      StringUtil::methodNameGenerateLabel($identifier),
      $translate,
    );
  }

}
