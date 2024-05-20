<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Formula;
use Ock\Ock\FormulaAdapter;
use Ock\Ock\Util\UtilBase;

final class Generator extends UtilBase {

  /**
   * Materializes a generator from an interface.
   *
   * @param string $interface
   *   Interface name.
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *   Service that can materialize other objects from formulas.
   *
   * @return \Ock\Ock\Generator\GeneratorInterface
   *   Generator. Evaluating the code of this generator should create an
   *   instance of $interface.
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   *   Cannot build a generator for the given interface.
   */
  public static function fromIface(
    string $interface,
    UniversalAdapterInterface $universalAdapter
  ): GeneratorInterface {
    return self::fromFormula(
      Formula::iface($interface),
      $universalAdapter);
  }

  /**
   * Materializes a generator from a formula.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   *   Formula.
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *   Service that can materialize other objects from formulas.
   *
   * @return \Ock\Ock\Generator\GeneratorInterface
   *   Materialized generator.
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   *   Cannot build a generator for the given formula.
   */
  public static function fromFormula(
    FormulaInterface $formula,
    UniversalAdapterInterface $universalAdapter
  ): GeneratorInterface {
    return FormulaAdapter::requireObject(
      $formula,
      GeneratorInterface::class,
      $universalAdapter,
    );
  }

}
