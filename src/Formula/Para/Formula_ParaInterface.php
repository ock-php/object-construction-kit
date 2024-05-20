<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Para;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\FormulaBase\Formula_ConfPassthruInterface;

interface Formula_ParaInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getParaFormula(): FormulaInterface;

}
