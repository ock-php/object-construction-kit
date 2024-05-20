<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

interface GeneratorInterface {

  /**
   * @param mixed $conf
   *
   * @return string
   *
   * @throws \Ock\Ock\Exception\GeneratorException
   *   Configuration is incompatible or not supported.
   */
  public function confGetPhp(mixed $conf): string;

}
