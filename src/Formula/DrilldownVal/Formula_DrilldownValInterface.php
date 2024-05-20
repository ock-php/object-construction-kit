<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\DrilldownVal;

use Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface;
use Ock\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Ock\Ock\V2V\Drilldown\V2V_DrilldownInterface;

interface Formula_DrilldownValInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface
   */
  public function getDecorated(): Formula_DrilldownInterface;

  /**
   * @return \Ock\Ock\V2V\Drilldown\V2V_DrilldownInterface
   */
  public function getV2V(): V2V_DrilldownInterface;

}
