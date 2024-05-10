<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Drilldown;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Id\Formula_IdInterface;
use Donquixote\Ock\IdToFormula\IdToFormulaInterface;

interface Formula_DrilldownInterface extends FormulaInterface {

  /**
   * @return \Donquixote\Ock\Formula\Id\Formula_IdInterface
   */
  public function getIdFormula(): Formula_IdInterface;

  /**
   * @return \Donquixote\Ock\IdToFormula\IdToFormulaInterface
   */
  public function getIdToFormula(): IdToFormulaInterface;

  /**
   * @return string
   */
  public function getIdKey(): string;

  /**
   * @return string|null
   */
  public function getOptionsKey(): ?string;

  /**
   * @return bool
   */
  public function allowsNull(): bool;

}
