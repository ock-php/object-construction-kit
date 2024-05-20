<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\SkipEvaluator;

use Ock\Ock\Core\Formula\FormulaInterface;

/**
 * Base interface for all formula decorators that have no effect on evaluators.
 */
interface Formula_ValuePassthruInterface extends FormulaInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

}
