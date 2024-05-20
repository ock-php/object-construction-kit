<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\ContextProviding;

use Ock\Ock\Context\CfContextInterface;
use Ock\Ock\Formula\SkipEvaluator\Formula_ValuePassthruInterface;

/**
 * @see \Ock\Ock\Todo\ContextTodo
 */
interface Formula_ContextProvidingInterface extends Formula_ValuePassthruInterface {

  /**
   * Gets a context to limit available option.
   *
   * @return \Ock\Ock\Context\CfContextInterface|null
   *   Context, or NULL for no limitations.
   */
  public function getContext(): ?CfContextInterface;

}
