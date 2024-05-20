<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\FixedConf;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Optionless\Formula_OptionlessInterface;

interface Formula_FixedConfInterface extends Formula_OptionlessInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return mixed
   */
  public function getConf(): mixed;

}
