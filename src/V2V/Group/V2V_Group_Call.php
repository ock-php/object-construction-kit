<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Group;

use Ock\CodegenTools\Util\CodeGen;

class V2V_Group_Call implements V2V_GroupInterface {

  /**
   * Constructor.
   *
   * @param string $fqn
   * @param string[]|null $argNames
   */
  private function __construct(
    private readonly string $fqn,
    private readonly ?array $argNames,
  ) {}

  /**
   * @param string $fqn
   * @param \ReflectionParameter[] $parameters
   *
   * @return self
   */
  private static function fromFqn(string $fqn, array $parameters): self {
    return new self($fqn, array_map(
      static fn (\ReflectionParameter $parameter) => $parameter->getName(),
      $parameters,
    ));
  }

  /**
   * @param string|class-string $class
   *   Class name which may or may not be verified to exist.
   *
   * @return self
   *
   * @throws \ReflectionException
   *   Class not found.
   */
  public static function fromClass(string $class): self {
    return self::fromFqn(
      'new \\' . $class,
      (new \ReflectionClass($class))->getConstructor()?->getParameters() ?? [],
    );
  }

  /**
   * @param callable $callable
   *
   * @return self
   *
   * @throws \ReflectionException
   */
  public static function fromCallable(callable $callable): self {
    if (is_array($callable)) {
      [$classOrObject, $method] = $callable;
      if (!is_string($classOrObject)) {
        throw new \InvalidArgumentException('Method must be static.');
      }
      return self::fromFqn(
        '\\' . $classOrObject . '::' . $method,
        (new \ReflectionMethod($classOrObject, $method))
          ->getParameters(),
      );
    }
    if (is_string($callable)) {
      return self::fromFqn(
        '\\' . $callable,
        (new \ReflectionFunction($callable))
          ->getParameters(),
      );
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
    return new self(
      $objectPhp . '->' . $method,
      null,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
    $itemsPhp = array_values($itemsPhp);
    // @todo Write tests, investigate why the code block is suppressed.
    // @phpstan-ignore booleanAnd.rightAlwaysFalse
    if ($this->argNames !== NULL && false) {
      foreach ($itemsPhp as $i => &$argPhp) {
        $argPhp = $this->argNames[$i] . ': ' . $argPhp;
      }
    }
    return CodeGen::phpCallFqn($this->fqn, $itemsPhp);
  }

}
