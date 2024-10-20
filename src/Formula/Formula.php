<?php

declare(strict_types=1);

namespace Ock\Ock\Formula;

use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\CodegenTools\Util\CodeGen;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Group\GroupFormulaBuilder;
use Ock\Ock\Formula\Iface\Formula_Iface;
use Ock\Ock\Formula\Optionless\Formula_OptionlessInterface;
use Ock\Ock\Formula\Select\Flat\FlatSelectBuilderInterface;
use Ock\Ock\Formula\Select\Flat\Formula_FlatSelect_Fixed;
use Ock\Ock\Formula\Sequence\Formula_Sequence;
use Ock\Ock\Formula\ValueProvider\Formula_FixedPhp;
use Ock\Ock\Util\UtilBase;

final class Formula extends UtilBase {

  /**
   * Validates one or more formulas.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface ...$formulas
   *   Formulas to validate.
   *   In PHP < 8.0, string keys are not allowed here.
   */
  public static function validate(FormulaInterface ...$formulas): void {}

  /**
   * Validates an array of formulas.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface[] $formulas
   *   Array of formulas to validate.
   *   This array can have string keys.
   */
  public static function validateMultiple(array $formulas): void {
    self::validate(...array_values($formulas));
  }

  /**
   * Starts a builder for a select formula.
   *
   * @return \Ock\Ock\Formula\Select\Flat\FlatSelectBuilderInterface
   */
  public static function flatSelect(): FlatSelectBuilderInterface {
    return new Formula_FlatSelect_Fixed([]);
  }

  /**
   * Creates a formula where the value is an interface instance.
   *
   * @param class-string $interface
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public static function iface(string $interface): FormulaInterface {
    return new Formula_Iface($interface);
  }

  /**
   * Creates a formula where the value is an interface instance or NULL.
   *
   * @param class-string $interface
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public static function ifaceOrNull(string $interface): FormulaInterface {
    return new Formula_Iface($interface, TRUE);
  }

  /**
   * Creates a formula where the value is an array of interface instances.
   *
   * @param class-string $interface
   *
   * @return \Ock\Ock\Formula\Sequence\Formula_Sequence
   */
  public static function ifaceSequence(string $interface): Formula_Sequence {
    return new Formula_Sequence(
      new Formula_Iface($interface));
  }

  /**
   * Starts a fluent builder for a group formula.
   *
   * @return \Ock\Ock\Formula\Group\GroupFormulaBuilder
   */
  public static function group(): GroupFormulaBuilder {
    return new GroupFormulaBuilder();
  }

  /**
   * Converts a formula to a less abstract version.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  public static function replace(
    FormulaInterface $formula,
    UniversalAdapterInterface $universalAdapter,
  ): ?FormulaInterface {
    return $universalAdapter->adapt($formula, FormulaInterface::class);
  }

  /**
   * @param mixed $value
   *
   * @return \Ock\Ock\Formula\Optionless\Formula_OptionlessInterface
   *
   * @throws \Exception
   *   Value cannot be exported.
   */
  public static function value(mixed $value): Formula_OptionlessInterface {
    return self::valuePhp(CodeGen::phpValue($value));
  }

  /**
   * @param mixed $value
   *
   * @return \Ock\Ock\Formula\Optionless\Formula_OptionlessInterface
   */
  public static function valueSimple(mixed $value): Formula_OptionlessInterface {
    return self::valuePhp(CodeGen::phpValueUnchecked($value));
  }

  /**
   * @param string $php
   *   Value expression in php.
   *
   * @return \Ock\Ock\Formula\Optionless\Formula_OptionlessInterface
   *   Formula with the fixed value.
   *   This formula is optionless, which means it defines a value independent of
   *   any configuration.
   */
  public static function valuePhp(string $php): Formula_OptionlessInterface {
    return new Formula_FixedPhp($php);
  }

  /**
   * @param string $serviceId
   *
   * @return \Ock\Ock\Formula\ValueProvider\Formula_FixedPhp
   */
  public static function serviceExpression(string $serviceId): Formula_FixedPhp {
    return new Formula_FixedPhp(CodeGen::phpCallMethod(
      '$container',
      'get',
      [var_export($serviceId, TRUE)],
    ));
  }

  /**
   * @param string $serviceId
   * @param string $method
   * @param mixed[] $args
   *
   * @return \Ock\Ock\Formula\ValueProvider\Formula_FixedPhp
   */
  public static function serviceMethodCallExpression(string $serviceId, string $method, array $args): Formula_FixedPhp {
    return new Formula_FixedPhp(CodeGen::phpCallMethod(
      '$container',
      'get',
      [var_export($serviceId, TRUE)],
    ));
  }

}
