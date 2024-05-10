<?php

declare(strict_types=1);

namespace Donquixote\Ock\Generator;

interface GeneratorInterface {

  /**
   * @param mixed $conf
   *
   * @return string
   *
   * @throws \Donquixote\Ock\Exception\GeneratorException
   *   Configuration is incompatible or not supported.
   */
  public function confGetPhp(mixed $conf): string;

}
