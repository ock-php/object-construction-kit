<?php

declare(strict_types=1);

namespace Donquixote\Ock\Evaluator;

use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Exception\EvaluatorException;
use Donquixote\Helpers\Util\MessageUtil;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Exception\EvaluatorException_IncompatibleConfiguration;
use Donquixote\Ock\Formula\Formula;
use Donquixote\Ock\FormulaAdapter;

class Evaluator {

  /**
   * @template T as object
   *
   * @param class-string<T> $interface
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $adapter
   *
   * @return \Donquixote\Ock\Evaluator\EvaluatorInterface<T>
   *
   * @throws \Donquixote\DID\Exception\EvaluatorException
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
   * @template T
   *
   * @param class-string<T> $interface
   * @param mixed $conf
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $adapter
   *
   * @return T
   *
   * @throws \Donquixote\DID\Exception\EvaluatorException
   */
  public static function objectFromConf(string $interface, mixed $conf, UniversalAdapterInterface $adapter): object {
    return self::iface($interface, $adapter)->confGetValue($conf);
  }

  /**
   * Materializes an evaluator from a formula.
   *
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $formula
   *   Formula.
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *   Service that can materialize other objects from formulas.
   *
   * @return \Donquixote\Ock\Evaluator\EvaluatorInterface
   *   Materialized evaluator.
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
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
   * @throws \Donquixote\Ock\Exception\EvaluatorException_IncompatibleConfiguration
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
   * @throws \Donquixote\Ock\Exception\EvaluatorException_IncompatibleConfiguration
   */
  public static function expectedConfigButFound(string $expected, mixed $conf): void {
    $message = $expected . ', found ' . MessageUtil::formatValue($conf);
    throw new EvaluatorException_IncompatibleConfiguration($message);
  }

}
