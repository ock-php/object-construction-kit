<?php

declare(strict_types=1);

namespace Donquixote\Ock\Exception;

/**
 * Exception to be thrown in generated code and in evaluators.
 *
 * @see \Donquixote\Ock\Evaluator\EvaluatorInterface
 */
class EvaluatorException extends \Exception {

  public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = NULL) {
    parent::__construct($message, $code, $previous);
  }

}
