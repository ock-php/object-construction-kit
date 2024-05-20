<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Drilldown;

use Ock\Ock\Formula\Select\Formula_SelectInterface;
use Ock\Ock\IdToFormula\IdToFormula_Null;
use Ock\Ock\Util\UtilBase;

final class Formula_Drilldown_SelectFormulaNull extends UtilBase {

  /**
   * @param \Ock\Ock\Formula\Select\Formula_SelectInterface $optionsFormula
   *
   * @return \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface
   */
  public static function create(Formula_SelectInterface $optionsFormula): Formula_DrilldownInterface {
    return new Formula_Drilldown(
      $optionsFormula,
      IdToFormula_Null::create());
  }

}
