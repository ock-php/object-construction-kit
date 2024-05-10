<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SequenceVal;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\V2V\Sequence\V2V_SequenceInterface;

interface Formula_SequenceValInterface {

  /**
   * @return \Donquixote\Ock\Formula\Sequence\Formula_SequenceInterface
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return \Donquixote\Ock\V2V\Sequence\V2V_SequenceInterface
   */
  public function getV2V(): V2V_SequenceInterface;

}
