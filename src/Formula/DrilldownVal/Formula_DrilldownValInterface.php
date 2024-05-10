<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\DrilldownVal;

use Donquixote\Ock\Formula\Drilldown\Formula_DrilldownInterface;
use Donquixote\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Donquixote\Ock\V2V\Drilldown\V2V_DrilldownInterface;

interface Formula_DrilldownValInterface extends Formula_ConfPassthruInterface {

  /**
   * @return \Donquixote\Ock\Formula\Drilldown\Formula_DrilldownInterface
   */
  public function getDecorated(): Formula_DrilldownInterface;

  /**
   * @return \Donquixote\Ock\V2V\Drilldown\V2V_DrilldownInterface
   */
  public function getV2V(): V2V_DrilldownInterface;

}
