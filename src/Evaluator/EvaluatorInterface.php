<?php

declare(strict_types=1);

namespace Ock\Ock\Evaluator;

/**
 * @template T of mixed
 */
interface EvaluatorInterface {

  /**
   * @param mixed $conf
   *   Configuration.
   *
   * @return T
   *   Object or value.
   *
   * @throws \Ock\Ock\Exception\EvaluatorException
   *   Failed to generate value.
   */
  public function confGetValue(mixed $conf): mixed;

}
