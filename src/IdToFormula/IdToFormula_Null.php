<?php

declare(strict_types=1);

namespace Ock\Ock\IdToFormula;

use Ock\Ock\Formula\ValueProvider\Formula_FixedPhp_Null;
use Ock\Ock\Util\UtilBase;

final class IdToFormula_Null extends UtilBase {

  /**
   * @return \Ock\Ock\IdToFormula\IdToFormulaInterface<Formula_FixedPhp_Null>
   */
  public static function create(): IdToFormulaInterface {
    return new IdToFormula_AlwaysTheSame(
      new Formula_FixedPhp_Null());
  }

}
