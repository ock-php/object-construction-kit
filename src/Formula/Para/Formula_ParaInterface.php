<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Para;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\FormulaBase\Formula_ConfPassthruInterface;

interface Formula_ParaInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getParaFormula(): FormulaInterface;

}
