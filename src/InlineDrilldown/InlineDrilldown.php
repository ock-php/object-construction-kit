<?php

declare(strict_types=1);

namespace Ock\Ock\InlineDrilldown;

use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\FormulaAdapter;
use Ock\Ock\Util\UtilBase;

final class InlineDrilldown extends UtilBase {

  /**
   * Materializes an InlineDrilldown object from a formula.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   *   Formula.
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *   Service that can materialize other objects from formulas.
   *
   * @return \Ock\Ock\InlineDrilldown\InlineDrilldownInterface
   *   Materialized PluginList.
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   *   Cannot build a PluginList for the given formula.
   */
  public static function fromFormula(
    FormulaInterface $formula,
    UniversalAdapterInterface $universalAdapter
  ): InlineDrilldownInterface {
    return FormulaAdapter::requireObject(
      $formula,
      InlineDrilldownInterface::class,
      $universalAdapter,
    );
  }

}
