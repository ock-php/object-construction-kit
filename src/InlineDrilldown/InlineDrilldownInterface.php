<?php

declare(strict_types=1);

namespace Donquixote\Ock\InlineDrilldown;

use Donquixote\Ock\Formula\Id\Formula_IdInterface;
use Donquixote\Ock\IdToFormula\IdToFormulaInterface;

interface InlineDrilldownInterface extends IdToFormulaInterface {

  /**
   * @return \Donquixote\Ock\Formula\Id\Formula_IdInterface
   */
  public function getIdFormula(): Formula_IdInterface;

}
