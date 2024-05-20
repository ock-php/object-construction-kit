<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Group;

use Ock\CodegenTools\Util\CodeGen;

class V2V_Group_CallNamedArgs implements V2V_GroupInterface {

  /**
   * @param class-string $class
   *
   * @return self
   */
  public static function fromClass(string $class): self {
    return new self('new \\' . $class);
  }

  /**
   * @param callable&array{class-string, string} $method
   *
   * @return self
   */
  public static function fromStaticMethod(array $method): self {
    if (!is_callable($method) || !is_string($method[0])) {
      throw new \InvalidArgumentException('Must be a static method.');
    }
    return new self('\\' . $method[0] . '::' . $method[1]);
  }

  /**
   * @param callable-string $function
   *
   * @return self
   */
  public static function fromFunction(string $function): self {
    if (!\function_exists($function)) {
      throw new \InvalidArgumentException(\sprintf('Function %s not found.', $function));
    }
    return new self('\\' . $function);
  }

  /**
   * @param callable $callable
   *
   * @return self
   */
  public static function fromCallable(callable $callable): self {
    if (is_array($callable)) {
      if (!is_string($callable[0]) || !isset($callable[1])) {
        throw new \InvalidArgumentException('Method must be static.');
      }
      return new self('\\' . $callable[0] . '::' . $callable[1]);
    }
    if (is_string($callable)) {
      return new self('\\' . $callable);
    }
    throw new \InvalidArgumentException('Callable must be a static method or a global function.');
  }

  /**
   * @param string $objectPhp
   * @param string $method
   *
   * @return self
   */
  public static function fromObjectMethod(string $objectPhp, string $method): self {
    return new self($objectPhp . '->' . $method);
  }

  /**
   * Constructor.
   *
   * @param string $fqn
   */
  private function __construct(
    private readonly string $fqn,
  ) {}

  /**
   * {@inheritdoc}
   * @param array $conf
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
    return CodeGen::phpCallFqn($this->fqn, $itemsPhp);
  }

}
