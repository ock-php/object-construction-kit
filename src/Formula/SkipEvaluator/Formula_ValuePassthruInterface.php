<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SkipEvaluator;

use Donquixote\Ock\Core\Formula\FormulaInterface;

/**
 * Base interface for all formula decorators that have no effect on evaluators.
 */
interface Formula_ValuePassthruInterface extends FormulaInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

}
