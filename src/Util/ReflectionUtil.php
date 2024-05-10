<?php

declare(strict_types=1);

namespace Donquixote\Ock\Util;

class ReflectionUtil {

  /**
   * @param mixed|callable $callable
   *
   * @return \ReflectionFunctionAbstract
   *
   * @throws \ReflectionException
   *   Callback does not exist, or is not supported.
   */
  public static function reflectCallable(callable $callable): \ReflectionFunctionAbstract {
    if (\is_string($callable)) {
      if (!\str_contains($callable, '::')) {
        return new \ReflectionFunction($callable);
      }
      return new \ReflectionMethod(...explode('::', $callable));
    }
    if (\is_object($callable)) {
      if ($callable instanceof \Closure) {
        return new \ReflectionFunction($callable);
      }
      if (!method_exists($callable, '__invoke')) {
        throw new \ReflectionException('Missing method __invoke().');
      }
      return new \ReflectionMethod($callable, '__invoke');
    }
    if (!\is_array($callable)) {
      throw new \ReflectionException('Unexpected value for callable.');
    }
    if (\array_keys($callable) !== [0, 1]) {
      throw new \ReflectionException('Unexpected value for callable.');
    }
    return new \ReflectionMethod(...$callable);
  }

}
