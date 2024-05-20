<?php

declare(strict_types=1);

namespace Ock\Ock\Util;

/**
 * @see \Ock\Ock\Todo\DecoTodo
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
