<?php

declare(strict_types=1);

namespace Ock\Ock\Contract;

use Ock\Ock\Core\Formula\FormulaInterface;

/**
 * Generic interface for objects that provide a formula.
 */
interface FormulaHavingInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface;

}
