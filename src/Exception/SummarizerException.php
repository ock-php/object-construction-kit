<?php

declare(strict_types=1);

namespace Donquixote\Ock\Exception;

/**
 * Malfunction in a summarizer.
 */
class SummarizerException extends \Exception {

  public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = NULL) {
    parent::__construct($message, $code, $previous);
  }

}
