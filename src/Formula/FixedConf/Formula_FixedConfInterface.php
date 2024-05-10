<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\FixedConf;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Optionless\Formula_OptionlessInterface;

interface Formula_FixedConfInterface extends Formula_OptionlessInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return mixed
   */
  public function getConf(): mixed;

}
