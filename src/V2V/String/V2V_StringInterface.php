<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\String;

interface V2V_StringInterface {

  /**
   * @param string $string
   *
   * @return string
   *
   * @throws \Donquixote\Ock\Exception\GeneratorException
   *   String value is incompatible or not supported.
   */
  public function stringGetPhp(string $string): string;

}
