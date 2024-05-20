<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\Parameter;

use Ock\Ock\Contract\FormulaHavingInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Boolean\Formula_Boolean_YesNo;

#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class Checkbox implements FormulaHavingInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface {
    return new Formula_Boolean_YesNo();
  }

}
