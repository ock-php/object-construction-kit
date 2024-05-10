<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\ContextProviding;

use Donquixote\Ock\Context\CfContextInterface;
use Donquixote\Ock\Formula\SkipEvaluator\Formula_ValuePassthruInterface;

/**
 * @see \Donquixote\Ock\Todo\ContextTodo
 */
interface Formula_ContextProvidingInterface extends Formula_ValuePassthruInterface {

  /**
   * Gets a context to limit available option.
   *
   * @return \Donquixote\Ock\Context\CfContextInterface|null
   *   Context, or NULL for no limitations.
   */
  public function getContext(): ?CfContextInterface;

}
