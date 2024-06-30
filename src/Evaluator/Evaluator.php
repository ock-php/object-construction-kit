<?php

declare(strict_types=1);

namespace Ock\Ock\Evaluator;

use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Exception\EvaluatorException;
use Ock\Ock\Exception\EvaluatorException_IncompatibleConfiguration;
use Ock\Ock\Formula\Formula;
use Ock\Ock\FormulaAdapter;

class Evaluator {

  /**
   * @template T as object
   *
   * @param class-string<T> $interface
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $adapter
   *
   * @return \Ock\Ock\Evaluator\EvaluatorInterface<T>
   *
   * @throws \Ock\Ock\Exception\EvaluatorException
   */
  public static function iface(string $interface, UniversalAdapterInterface $adapter): EvaluatorInterface {
    $formula = Formula::iface($interface);
    try {
      $evaluator = $adapter->adapt($formula, EvaluatorInterface::class);
    }
    catch (AdapterException $e) {
      throw new EvaluatorException(\sprintf(
        'Failed to obtain evaluator for %s',
        MessageUtil::formatValue($interface),
      ), 0, $e);
    }
    if (!$evaluator) {
      throw new EvaluatorException(\sprintf(
        'Failed to obtain evaluator for %s',
        MessageUtil::formatValue($interface),
      ));
    }
    return $evaluator;
  }

  /**
   * @template T of object
   *
   * @param class-string<T> $interface
   * @param mixed $conf
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $adapter
   *
   * @return T
   *
   * @throws \Ock\Ock\Exception\EvaluatorException
   */
  public static function objectFromConf(string $interface, mixed $conf, UniversalAdapterInterface $adapter): object {
    return self::iface($interface, $adapter)->confGetValue($conf);
  }

  /**
   * Materializes an evaluator from a formula.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   *   Formula.
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *   Service that can materialize other objects from formulas.
   *
   * @return \Ock\Ock\Evaluator\EvaluatorInterface
   *   Materialized evaluator.
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   *   Cannot build a evaluator for the given formula.
   */
  public static function fromFormula(
    FormulaInterface $formula,
    UniversalAdapterInterface $universalAdapter
  ): EvaluatorInterface {
    return FormulaAdapter::requireObject(
      $formula,
      EvaluatorInterface::class,
      $universalAdapter,
    );
  }

  /**
   * Throws an exception for incompatible configuration.
   *
   * @param string $message
   *   Message describing the problem.
   *
   * @return never-return
   *
   * @throws \Ock\Ock\Exception\EvaluatorException_IncompatibleConfiguration
   */
  public static function incompatibleConfiguration(string $message): void {
    throw new EvaluatorException_IncompatibleConfiguration($message);
  }

  /**
   * Throws an exception for incompatible configuration.
   *
   * @param string $expected
   *   Message describing the expected configuration.
   * @param mixed $conf
   *   Failing configuration.
   *
   * @return never-return
   *
   * @throws \Ock\Ock\Exception\EvaluatorException_IncompatibleConfiguration
   */
  public static function expectedConfigButFound(string $expected, mixed $conf): void {
    $message = $expected . ', found ' . MessageUtil::formatValue($conf);
    throw new EvaluatorException_IncompatibleConfiguration($message);
  }

}
