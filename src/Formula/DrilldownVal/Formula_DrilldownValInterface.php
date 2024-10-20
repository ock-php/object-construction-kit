<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\DrilldownVal;

use Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface;
use Ock\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Ock\Ock\V2V\Drilldown\V2V_DrilldownInterface;

/**
 * Decorates a drilldown formula to transform the value expression.
 */
interface Formula_DrilldownValInterface extends Formula_ConfPassthruInterface {

  /**
   * Gets the decorated drilldown formula.
   *
   * @return \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface
   */
  public function getDecorated(): Formula_DrilldownInterface;

  /**
   * Gets an object that does the transforms the value expression.
   *
   * Having this as a separate object allows to use the same value
   * transformation object in different contexts.
   *
   * @return \Ock\Ock\V2V\Drilldown\V2V_DrilldownInterface
   */
  public function getV2V(): V2V_DrilldownInterface;

}
