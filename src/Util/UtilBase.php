<?php

declare(strict_types=1);

namespace Ock\Ock\Util;

/**
 * Base class for utility classes which shall only have static methods.
 */
abstract class UtilBase {

  /**
   * Private constructor.
   *
   * Prevents any subclass to be instantiated.
   */
  final private function __construct() {}

}
