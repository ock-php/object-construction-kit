<?php

declare(strict_types=1);

namespace Ock\Ock\InlineDrilldown;

use Ock\Ock\Formula\Id\Formula_IdInterface;
use Ock\Ock\IdToFormula\IdToFormulaInterface;

/**
 * @template T of \Ock\Ock\Core\Formula\FormulaInterface
 *
 * @template-extends IdToFormulaInterface<T>
 */
interface InlineDrilldownInterface extends IdToFormulaInterface {

  /**
   * @return \Ock\Ock\Formula\Id\Formula_IdInterface
   */
  public function getIdFormula(): Formula_IdInterface;

}
