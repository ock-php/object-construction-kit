<?php

declare(strict_types=1);

namespace Donquixote\Ock\Context;

use Donquixote\DID\Util\ReflectionTypeUtil;

/**
 * @see \Donquixote\Ock\Todo\ContextTodo
 */
class CfContext implements CfContextInterface {

  /**
   * @var string|null
   */
  private ?string $machineName = null;

  /**
   * @param mixed[] $values
   *
   * @return self
   */
  public static function create(array $values = []): self {
    return new self($values);
  }

  /**
   * Constructor.
   *
   * @param mixed[] $values
   */
  public function __construct(
    private array $values = [],
  ) {}

  /**
   * @param string $paramName
   * @param mixed $value
   *
   * @return $this
   */
  public function paramNameSetValue(string $paramName, mixed $value): self {
    $this->values[$paramName] = $value;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function paramValueExists(\ReflectionParameter $param): bool {
    $class = ReflectionTypeUtil::getClassLikeType($param);
    if ($class === CfContextInterface::class) {
      return true;
    }
    return $this->paramNameHasValue($param->getName());
  }

  /**
   * {@inheritdoc}
   *
   * @noinspection PhpMixedReturnTypeCanBeReducedInspection
   */
  public function paramGetValue(\ReflectionParameter $param): mixed {
    $class = ReflectionTypeUtil::getClassLikeType($param);
    if ($class === CfContextInterface::class) {
      return $this;
    }
    return $this->paramNameGetValue($param->getName());
  }

  /**
   * {@inheritdoc}
   */
  public function paramNameHasValue(string $paramName): bool {
    return array_key_exists($paramName, $this->values);
  }

  /**
   * {@inheritdoc}
   */
  public function paramNameGetValue(string $paramName): mixed {
    return $this->values[$paramName] ?? NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getMachineName(): string {
    return $this->machineName
      ??= md5(serialize($this->values));
  }

}
