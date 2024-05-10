<?php

declare(strict_types=1);

namespace Donquixote\Ock\Exception;

/**
 * Failed to generate code.
 *
 * See child classes for more specific reasons.
 *
 * @see \Donquixote\Ock\Generator\GeneratorInterface
 */
class GeneratorException extends \Exception {

  public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = NULL) {
    parent::__construct($message, $code, $previous);
  }

}
