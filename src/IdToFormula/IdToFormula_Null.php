<?php

declare(strict_types=1);

namespace Donquixote\Ock\IdToFormula;

use Donquixote\Ock\Formula\ValueProvider\Formula_FixedPhp_Null;
use Donquixote\Ock\Util\UtilBase;

final class IdToFormula_Null extends UtilBase {

  /**
   * @return \Donquixote\Ock\IdToFormula\IdToFormulaInterface
   */
  public static function create(): IdToFormulaInterface {
    return new IdToFormula_AlwaysTheSame(
      new Formula_FixedPhp_Null());
  }

}
