<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Neutral;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\SkipEvaluator\Formula_ValuePassthruInterface;
use Donquixote\Ock\FormulaBase\Formula_ConfPassthruInterface;

interface Formula_PassthruInterface extends Formula_ConfPassthruInterface, Formula_ValuePassthruInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  public function getDecorated(): FormulaInterface;

}
