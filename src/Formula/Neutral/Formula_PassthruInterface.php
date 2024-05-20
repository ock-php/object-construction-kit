<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Neutral;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\SkipEvaluator\Formula_ValuePassthruInterface;
use Ock\Ock\FormulaBase\Formula_ConfPassthruInterface;

interface Formula_PassthruInterface extends Formula_ConfPassthruInterface, Formula_ValuePassthruInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function getDecorated(): FormulaInterface;

}
