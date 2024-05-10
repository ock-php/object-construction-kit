<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Drilldown\Option;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Select\Option\SelectOptionInterface;

/**
 * Object representation of a plugin definition.
 *
 * Experimental, not used yet.
 *
 * To make this work, the object should be serializable for caching purposes.
 */
interface DrilldownOptionInterface extends SelectOptionInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface;

}
