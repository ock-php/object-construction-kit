<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Contextual;

use Ock\Ock\Context\CfContextInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\SkipEvaluator\Formula_ValuePassthruInterface;

/**
 * @see \Ock\Ock\Todo\ContextTodo
 */
interface Formula_ContextualInterface extends Formula_ValuePassthruInterface {

  /**
   * Gets a formula with a context applied.
   *
   * @param \Ock\Ock\Context\CfContextInterface|null $context
   *   Context to limit available options, or NULL for no limitations.
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *   Decorated formula with the context applied.
   */
  public function getDecorated(CfContextInterface $context = NULL): FormulaInterface;

}
