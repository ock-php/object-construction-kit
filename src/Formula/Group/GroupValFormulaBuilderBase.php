<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Group;

use Ock\CodegenTools\Util\CodeGen;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Exception\FormulaException;
use Ock\Ock\Formula\GroupVal\Formula_GroupVal;
use Ock\Ock\V2V\Group\V2V_Group_Call;
use Ock\Ock\V2V\Group\V2V_Group_ExpressionCallback;
use Ock\Ock\V2V\Group\V2V_Group_Fixed;
use Ock\Ock\V2V\Group\V2V_Group_ObjectMethodCall;
use Ock\Ock\V2V\Group\V2V_Group_PhpPlaceholders;
use Ock\Ock\V2V\Group\V2V_Group_Pick;
use Ock\Ock\V2V\Group\V2V_Group_Rekey;
use Ock\Ock\V2V\Group\V2V_Group_Trivial;
use Ock\Ock\V2V\Group\V2V_GroupInterface;

abstract class GroupValFormulaBuilderBase {

  /**
   * @param string $key
   * @param class-string $class
   * @param list<string> $keys
   *
   * @return \Ock\Ock\Formula\Group\GroupValFormulaBuilder
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addConstruct(string $key, string $class, array $keys = []): GroupValFormulaBuilder {
    try {
      return $this->addExpression(
        $key,
        V2V_Group_Call::fromClass($class),
        $keys,
      );
    }
    catch (\ReflectionException $e) {
      throw new FormulaException($e->getMessage(), 0, $e);
    }
  }

  /**
   * @param string $key
   * @param callable $callback
   * @param list<string> $sourceKeys
   *
   * @return \Ock\Ock\Formula\Group\GroupValFormulaBuilder
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addCall(string $key, callable $callback, array $sourceKeys = []): GroupValFormulaBuilder {
    try {
      return $this->addExpression(
        $key,
        V2V_Group_Call::fromCallable($callback),
        $sourceKeys,
      );
    }
    catch (\ReflectionException $e) {
      throw new FormulaException($e->getMessage(), 0, $e);
    }
  }

  /**
   * @param string $key
   * @param string $objectKey
   * @param string $method
   * @param array $paramKeys
   *
   * @return \Ock\Ock\Formula\Group\GroupValFormulaBuilder
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addObjectMethodCall(string $key, string $objectKey, string $method, array $paramKeys): GroupValFormulaBuilder {
    return $this->addExpression(
      $key,
      new V2V_Group_ObjectMethodCall($objectKey, $method, $paramKeys),
    );
  }

  /**
   * @param string $key
   * @param \Ock\Ock\V2V\Group\V2V_GroupInterface $v2v
   * @param list<string>|null $keys
   *
   * @return \Ock\Ock\Formula\Group\GroupValFormulaBuilder
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addExpression(string $key, V2V_GroupInterface $v2v, array $keys = NULL): GroupValFormulaBuilder {
    if ($keys !== NULL) {
      $v2v = new V2V_Group_Rekey($v2v, $keys);
    }
    return $this->doAddExpression($key, $v2v);
  }

  /**
   * @param string[] $keys
   * @param string $glue
   * @param string $sourceConfKey
   *
   * @return \Ock\Ock\Formula\Group\GroupValFormulaBuilder
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addStringPartExpressions(array $keys, string $glue, string $sourceConfKey): GroupValFormulaBuilder {
    $instance = $this;
    foreach ($keys as $i => $key) {
      $instance = $instance->doAddExpression(
        $key,
        new V2V_Group_ExpressionCallback(
          function (array $itemsPhp, array $conf) use ($i, $sourceConfKey, $glue): string {
            return var_export(explode($glue, $conf[$sourceConfKey])[$i], TRUE);
          },
        ),
      );
    }
    return $instance;
  }

  /**
   * @param string $key
   * @param callable(string[], mixed[]): string $expressionCallback
   *
   * @return \Ock\Ock\Formula\Group\GroupValFormulaBuilder
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addExpressionCallback(string $key, callable $expressionCallback): GroupValFormulaBuilder {
    $v2v = new V2V_Group_ExpressionCallback($expressionCallback);
    return $this->doAddExpression($key, $v2v);
  }

  /**
   * @param string[] $keys
   * @param callable(string[], mixed[]): (string[]) $multiExpressionCallback
   *
   * @return \Ock\Ock\Formula\Group\GroupValFormulaBuilder
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addMultiExpressionCallback(array $keys, callable $multiExpressionCallback): GroupValFormulaBuilder {
    $instance = $this;
    foreach ($keys as $i => $key) {
      $v2v = new V2V_Group_ExpressionCallback(
        fn (array $itemsPhp, array $conf) => $multiExpressionCallback($itemsPhp, $conf)[$i],
      );
      $instance = $this->doAddExpression($key, $v2v);
    }
    return $instance;
  }

  /**
   * @param string $key
   * @param string $phpWithPlaceholders
   *
   * @return \Ock\Ock\Formula\Group\GroupValFormulaBuilder
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addExpressionPhp(string $key, string $phpWithPlaceholders): GroupValFormulaBuilder {
    return $this->addExpression(
      $key,
      new V2V_Group_PhpPlaceholders($phpWithPlaceholders),
    );
  }

  /**
   * Adds an optionless group option.
   *
   * @param string $key
   * @param mixed $value
   *
   * @return \Ock\Ock\Formula\Group\GroupValFormulaBuilder
   *
   * @throws \Exception
   *   Value is not supported for export.
   */
  public function addValue(string $key, mixed $value): GroupValFormulaBuilder {
    return $this->addValuePhp($key, CodeGen::phpValue($value));
  }

  /**
   * Adds an optionless group option.
   *
   * @param string $key
   * @param string|int|bool|float $value
   *
   * @return \Ock\Ock\Formula\Group\GroupValFormulaBuilder
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addScalar(string $key, string|int|bool|float $value): GroupValFormulaBuilder {
    return $this->addValuePhp($key, CodeGen::phpValueUnchecked($value));
  }

  /**
   * @param string $key
   * @param callable $callback
   *
   * @return \Ock\Ock\Formula\Group\GroupValFormulaBuilder
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addValueCall(string $key, callable $callback): GroupValFormulaBuilder {
    return $this->addValuePhp($key, CodeGen::phpCall($callback));
  }

  /**
   * @param string $key
   * @param string $php
   *
   * @return \Ock\Ock\Formula\Group\GroupValFormulaBuilder
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function addValuePhp(string $key, string $php): GroupValFormulaBuilder {
    return $this->addExpression($key, new V2V_Group_Fixed($php));
  }

  /**
   * Constructs a class with group options as parameters.
   *
   * @param string $class
   * @param string[]|null $keys
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *
   * @throws \ReflectionException
   *   Class does not exist.
   */
  public function construct(string $class, array $keys = NULL): FormulaInterface {
    return $this->val(V2V_Group_Call::fromClass($class), $keys);
  }

  /**
   * Endpoint. Calls a factory callback with the group options as parameters.
   *
   * @param callable $callback
   * @param string[]|null $keys
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function call(callable $callback, array $keys = NULL): FormulaInterface {
    return $this->val(V2V_Group_Call::fromCallable($callback), $keys);
  }

  /**
   * Endpoint. Calls an object method.
   *
   * @param string $objectKey
   * @param string $method
   * @param array $paramKeys
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function callObjectMethod(string $objectKey, string $method, array $paramKeys): FormulaInterface {
    return $this->val(new V2V_Group_ObjectMethodCall(
      $objectKey,
      $method,
      $paramKeys,
    ));
  }

  /**
   * @param \Ock\Ock\V2V\Group\V2V_GroupInterface $v2v
   * @param string[]|null $keys
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function val(V2V_GroupInterface $v2v, array $keys = NULL): FormulaInterface {
    return $this->buildGroupValFormula($v2v, $keys);
  }

  /**
   * @param string $phpWithPlaceholders
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function buildPhp(string $phpWithPlaceholders): FormulaInterface {
    return $this->buildGroupValFormula(
      new V2V_Group_PhpPlaceholders($phpWithPlaceholders),
    );
  }

  /**
   * @param class-string $class
   * @param array $phpArgsWithPlaceholders
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function constructPhp(string $class, array $phpArgsWithPlaceholders): FormulaInterface {
    return $this->buildPhp(CodeGen::phpConstruct(
      $class,
      $phpArgsWithPlaceholders,
    ));
  }

  /**
   * @param callable $callback
   * @param array $phpArgsWithPlaceholders
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function callPhp(callable $callback, array $phpArgsWithPlaceholders): FormulaInterface {
    return $this->buildPhp(CodeGen::phpCall(
      $callback,
      $phpArgsWithPlaceholders,
    ));
  }

  /**
   * @param string[] $keys
   *
   * @return \Ock\Ock\Formula\GroupVal\Formula_GroupVal
   */
  public function buildRekeyed(array $keys): Formula_GroupVal {
    return $this->buildGroupValFormula(NULL, $keys);
  }

  /**
   * @param \Ock\Ock\V2V\Group\V2V_GroupInterface|null $v2v
   * @param string[]|null $keys
   *
   * @return \Ock\Ock\Formula\GroupVal\Formula_GroupVal|\Ock\Ock\Formula\Group\Formula_Group
   */
  public function buildGroupValFormula(V2V_GroupInterface $v2v = NULL, array $keys = NULL): Formula_GroupVal|Formula_Group {
    $formula = $this->getGroupFormula();
    $v2v = $this->decorateV2V($v2v);
    if ($keys) {
      $v2v = new V2V_Group_Rekey(
        $v2v ?? new V2V_Group_Trivial(),
        $keys,
      );
    }
    if (!$v2v) {
      return $formula;
    }
    return new Formula_GroupVal($formula, $v2v);
  }

  /**
   * @param callable $getPhp
   * @param string[]|null $keys
   *
   * @return \Ock\Ock\Formula\GroupVal\Formula_GroupVal
   */
  public function generate(callable $getPhp, array $keys = NULL): Formula_GroupVal {
    return $this->buildGroupValFormula(
      new class ($getPhp) implements V2V_GroupInterface {
        public function __construct(private $getPhp) {}
        public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
          return ($this->getPhp)($itemsPhp, $conf);
        }
      },
      $keys,
    );
  }

  /**
   * @param string $key
   *
   * @return \Ock\Ock\Formula\GroupVal\Formula_GroupVal
   */
  public function pick(string $key): Formula_GroupVal {
    return $this->buildGroupValFormula(new V2V_Group_Pick($key));
  }

  /**
   * @param string $key
   * @param \Ock\Ock\V2V\Group\V2V_GroupInterface $v2v
   *
   * @return \Ock\Ock\Formula\Group\GroupValFormulaBuilder
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  abstract protected function doAddExpression(string $key, V2V_GroupInterface $v2v): GroupValFormulaBuilder;

  /**
   * @param \Ock\Ock\V2V\Group\V2V_GroupInterface|null $v2v
   *
   * @return \Ock\Ock\V2V\Group\V2V_GroupInterface|null
   */
  abstract protected function decorateV2V(?V2V_GroupInterface $v2v): ?V2V_GroupInterface;

  /**
   * @return \Ock\Ock\Formula\Group\Formula_Group
   */
  abstract protected function getGroupFormula(): Formula_Group;

}
