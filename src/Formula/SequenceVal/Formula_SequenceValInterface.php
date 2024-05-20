<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\SequenceVal;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\V2V\Sequence\V2V_SequenceInterface;

interface Formula_SequenceValInterface {

  /**
   * @return \Ock\Ock\Formula\Sequence\Formula_SequenceInterface
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return \Ock\Ock\V2V\Sequence\V2V_SequenceInterface
   */
  public function getV2V(): V2V_SequenceInterface;

}
