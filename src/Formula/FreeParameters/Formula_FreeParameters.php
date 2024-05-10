<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\FreeParameters;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Util\ReflectionUtil;

class Formula_FreeParameters extends Formula_FreeParametersBase {

  /**
   * @param class-string<\Donquixote\Ock\Core\Formula\FormulaInterface> $class
   * @param mixed[] $knownArgs
   *
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   *
   * @throws \ReflectionException
   *   Class does not exist.
   */
  public static function fromClass(string $class, array $knownArgs = []): FormulaInterface {
    $reflectionClass = new \ReflectionClass($class);
    return self::create(
      [$reflectionClass, 'newInstance'],
      $reflectionClass->getConstructor()?->getParameters() ?? [],
      $knownArgs,
    );
  }

  /**
   * @param callable(mixed...): \Donquixote\Ock\Core\Formula\FormulaInterface $callback
   * @param mixed[] $knownArgs
   *
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   *
   * @throws \ReflectionException
   *   Callable does not exist, or is not reflectable.
   */
  public static function fromFormulaCallback(callable $callback, array $knownArgs = []): FormulaInterface {
    $reflectionFunction = ReflectionUtil::reflectCallable($callback);
    return self::create(
      $callback,
      $reflectionFunction->getParameters(),
      $knownArgs,
    );
  }

  /**
   * @param callable $callback
   * @param \ReflectionParameter[] $allParameters
   * @param mixed[] $knownArgs
   *
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public static function create(
    callable $callback,
    array $allParameters,
    array $knownArgs = [],
  ): FormulaInterface {
    return (new self(
      $callback,
      $allParameters,
    ))->withArgValues($knownArgs);
  }

  /**
   * Constructor.
   *
   * @param callable $callback
   * @param \ReflectionParameter[] $openParameters
   */
  public function __construct(
    private readonly mixed $callback,
    array $openParameters,
  ) {
    if (!array_is_list($openParameters)) {
      throw new \InvalidArgumentException('Unexpected keys or order in parameter list.');
    }
    parent::__construct($openParameters);
  }

  /**
   * {@inheritdoc}
   */
  protected function callArgs(array $args): FormulaInterface {
    return ($this->callback)(...$args);
  }

}
