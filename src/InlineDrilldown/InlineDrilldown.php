<?php

declare(strict_types=1);

namespace Donquixote\Ock\InlineDrilldown;

use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\FormulaAdapter;
use Donquixote\Ock\Util\UtilBase;

final class InlineDrilldown extends UtilBase {

  /**
   * Materializes an InlineDrilldown object from a formula.
   *
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $formula
   *   Formula.
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *   Service that can materialize other objects from formulas.
   *
   * @return \Donquixote\Ock\InlineDrilldown\InlineDrilldownInterface
   *   Materialized PluginList.
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
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
