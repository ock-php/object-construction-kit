<?php

declare(strict_types=1);

namespace Donquixote\Ock\Util;

/**
 * @see \Donquixote\Ock\Todo\DecoTodo
 */
class DecoUtil extends UtilBase {

  const PLACEHOLDER = '\\' . self::class . '::' . [self::class, 'placeholder'][1];

  /**
   * @throws \Exception
   */
  public static function placeholder(): never {
    // @todo Better exception type and message.
    throw new \Exception();
  }

}
