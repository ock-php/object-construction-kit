<?php

declare(strict_types=1);

namespace Ock\Ock\Context;

/**
 * @see \Ock\Ock\Todo\ContextTodo
 */
interface CfContextInterface {

  /**
   * @param \ReflectionParameter $param
   *
   * @return bool
   *
   * @throws \Exception
   */
  public function paramValueExists(\ReflectionParameter $param): bool;

  /**
   * @param \ReflectionParameter $param
   *
   * @return mixed
   *
   * @throws \Exception
   */
  public function paramGetValue(\ReflectionParameter $param): mixed;

  /**
   * @param string $paramName
   *
   * @return bool
   */
  public function paramNameHasValue(string $paramName): bool;

  /**
   * @param string $paramName
   *
   * @return mixed
   */
  public function paramNameGetValue(string $paramName): mixed;

  /**
   * @return string
   */
  public function getMachineName(): string;

}
