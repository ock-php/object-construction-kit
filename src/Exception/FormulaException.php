<?php

declare(strict_types=1);

namespace Ock\Ock\Exception;

/**
 * Malfunction in a formula.
 */
class FormulaException extends \Exception {

  public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = NULL) {
    parent::__construct($message, $code, $previous);
  }

}
