<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Drilldown;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Id\Formula_IdInterface;
use Ock\Ock\IdToFormula\IdToFormulaInterface;

/**
 * Choose an id, then get a sub-configuration based on the chosen id.
 *
 * The configuration may look like [$idKey => $id, $optionsKey => $options].
 * Or, if $optionsKey is NULL, it would be like [$idKey => $id] + $options.
 *
 * The resulting value expression is, by default, the one generated for the
 * sub-formula with the sub-configuration. This means that, by default, the id
 * itself is not used in the value expression.
 *
 * The formula can be decorated with a value transformation formula to further
 * wrap the value expression, with the possibility to incorporate the id.
 *
 * @see \Ock\Ock\Generator\Generator_Drilldown::createFromDrilldownFormula()
 * @see \Ock\Ock\Formula\DrilldownVal\Formula_DrilldownVal
 * @see \Ock\Ock\V2V\Drilldown\V2V_DrilldownInterface
 */
interface Formula_DrilldownInterface extends FormulaInterface {

  /**
   * Gets the formula used to choose and validate the id.
   *
   * @return \Ock\Ock\Formula\Id\Formula_IdInterface
   */
  public function getIdFormula(): Formula_IdInterface;

  /**
   * Gets a lookup element to get the sub-formula for a given id.
   *
   * The lookup is a separate object, not part of the drilldown formula itself.
   * This allows to use the same formula lookup object in different contexts.
   *
   * @return \Ock\Ock\IdToFormula\IdToFormulaInterface<FormulaInterface>
   */
  public function getIdToFormula(): IdToFormulaInterface;

  /**
   * Gets the configuration key under which to find the id.
   *
   * @return string
   */
  public function getIdKey(): string;

  /**
   * Gets the configuration key under which to find the sub-configuration.
   *
   * If this is NULL, the entire root array is used as sub-configuration.
   *
   * @return string|null
   */
  public function getOptionsKey(): ?string;

  /**
   * Declares whether the id is allowed to be NULL.
   *
   * @return bool
   */
  public function allowsNull(): bool;

}
