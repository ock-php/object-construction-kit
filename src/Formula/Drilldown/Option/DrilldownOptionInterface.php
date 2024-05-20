<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Drilldown\Option;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Select\Option\SelectOptionInterface;

/**
 * Object representation of a plugin definition.
 *
 * Experimental, not used yet.
 *
 * To make this work, the object should be serializable for caching purposes.
 */
interface DrilldownOptionInterface extends SelectOptionInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface;

}
