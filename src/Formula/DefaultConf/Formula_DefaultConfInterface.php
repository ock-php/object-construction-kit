<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\DefaultConf;

use Donquixote\Ock\Core\Formula\FormulaInterface;

interface Formula_DefaultConfInterface extends FormulaInterface {

  /**
   * @return mixed
   */
  public function getDefaultConf(): mixed;

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

}
