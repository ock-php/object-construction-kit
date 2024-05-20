<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\TwoStepVal;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\V2V\TwoStep\V2V_TwoStepInterface;

interface Formula_TwoStepValInterface {

  /**
   * @return \Ock\Ock\Formula\TwoStep\Formula_TwoStepInterface
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return \Ock\Ock\V2V\TwoStep\V2V_TwoStepInterface
   */
  public function getV2V(): V2V_TwoStepInterface;

}
