<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\ValueProvider;

use Donquixote\CodegenTools\Util\CodeGen;

class Formula_FixedPhp implements Formula_FixedPhpInterface {

  /**
   * @param class-string $class
   * @param array $argsPhp
   *
   * @return self
   */
  public static function fromClass(string $class, array $argsPhp = []): self {
    return new self(
      CodeGen::phpConstruct($class, $argsPhp));
  }

  /**
   * @param callable $method
   * @param array $argsPhp
   *
   * @return self
   */
  public static function fromStaticMethod(callable $method, array $argsPhp = []): self {
    return new self(
      CodeGen::phpCallStatic($method, $argsPhp));
  }

  /**
   * @param callable-string $function
   * @param array $argsPhp
   *
   * @return self
   */
  public static function fromFunction(string $function, array $argsPhp = []): self {
    return new self(
      CodeGen::phpCallFunction($function, $argsPhp));
  }

  /**
   * Static factory. Creates an instance from a given value.
   *
   * Throws an "unchecked" exception on failure.
   *
   * @param mixed $value
   *   Simple value that is known to be safe for export.
   *
   * @return self
   */
  public static function fromValueSimple(mixed $value): self {
    return new self(CodeGen::phpValueUnchecked($value));
  }

  /**
   * Static factory. Creates an instance from a given value.
   *
   * @param mixed $value
   *   Value that is hoped to be safe for export.
   *
   * @return self
   *
   * @throws \Exception
   *   Value is not supported for export.
   */
  public static function fromValue(mixed $value): self {
    return new self(CodeGen::phpValue($value));
  }

  /**
   * Constructor.
   *
   * @param string $php
   *   PHP value expression.
   */
  public function __construct(
    private readonly string $php,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getPhp(): string {
    return $this->php;
  }

}
