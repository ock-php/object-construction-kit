<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Drilldown;

use Donquixote\Ock\Formula\Select\Formula_SelectInterface;
use Donquixote\Ock\IdToFormula\IdToFormula_Null;
use Donquixote\Ock\Util\UtilBase;

final class Formula_Drilldown_SelectFormulaNull extends UtilBase {

  /**
   * @param \Donquixote\Ock\Formula\Select\Formula_SelectInterface $optionsFormula
   *
   * @return \Donquixote\Ock\Formula\Drilldown\Formula_DrilldownInterface
   */
  public static function create(Formula_SelectInterface $optionsFormula): Formula_DrilldownInterface {
    return new Formula_Drilldown(
      $optionsFormula,
      IdToFormula_Null::create());
  }

}
