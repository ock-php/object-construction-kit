<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Drilldown;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Id\Formula_IdInterface;
use Ock\Ock\IdToFormula\IdToFormulaInterface;

interface Formula_DrilldownInterface extends FormulaInterface {

  /**
   * @return \Ock\Ock\Formula\Id\Formula_IdInterface
   */
  public function getIdFormula(): Formula_IdInterface;

  /**
   * @return \Ock\Ock\IdToFormula\IdToFormulaInterface
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
