<?php

declare(strict_types=1);

namespace Donquixote\Ock\Contract;

use Donquixote\Ock\Core\Formula\FormulaInterface;

/**
 * Generic interface for objects that provide a formula.
 */
interface PluginModifyingInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface;

}
