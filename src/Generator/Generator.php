<?php

declare(strict_types=1);

namespace Donquixote\Ock\Generator;

use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Formula;
use Donquixote\Ock\FormulaAdapter;
use Donquixote\Ock\Util\UtilBase;

final class Generator extends UtilBase {

  /**
   * Materializes a generator from an interface.
   *
   * @param string $interface
   *   Interface name.
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *   Service that can materialize other objects from formulas.
   *
   * @return \Donquixote\Ock\Generator\GeneratorInterface
   *   Generator. Evaluating the code of this generator should create an
   *   instance of $interface.
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
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
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $formula
   *   Formula.
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *   Service that can materialize other objects from formulas.
   *
   * @return \Donquixote\Ock\Generator\GeneratorInterface
   *   Materialized generator.
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
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
