<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\DefaultConf;

use Ock\Ock\Core\Formula\FormulaInterface;

interface Formula_DefaultConfInterface extends FormulaInterface {

  /**
   * @return mixed
   */
  public function getDefaultConf(): mixed;

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

}
