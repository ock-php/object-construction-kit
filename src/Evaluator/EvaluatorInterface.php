<?php

declare(strict_types=1);

namespace Donquixote\Ock\Evaluator;

/**
 * @template T as mixed
 */
interface EvaluatorInterface {

  /**
   * @param mixed $conf
   *   Configuration.
   *
   * @return T
   *   Object or value.
   *
   * @throws \Donquixote\DID\Exception\EvaluatorException
   *   Failed to generate value.
   */
  public function confGetValue(mixed $conf): mixed;

}
