<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Contextual;

use Donquixote\Ock\Context\CfContextInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\SkipEvaluator\Formula_ValuePassthruInterface;

/**
 * @see \Donquixote\Ock\Todo\ContextTodo
 */
interface Formula_ContextualInterface extends Formula_ValuePassthruInterface {

  /**
   * Gets a formula with a context applied.
   *
   * @param \Donquixote\Ock\Context\CfContextInterface|null $context
   *   Context to limit available options, or NULL for no limitations.
   *
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   *   Decorated formula with the context applied.
   */
  public function getDecorated(CfContextInterface $context = NULL): FormulaInterface;

}
