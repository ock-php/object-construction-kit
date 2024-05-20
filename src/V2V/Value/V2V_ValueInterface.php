<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Value;

interface V2V_ValueInterface {

  /**
   * @param string $php
   * @param mixed $conf
   *
   * @return string
   *
   * @throws \Ock\Ock\Exception\GeneratorException
   */
  public function phpGetPhp(string $php, mixed $conf): string;

}
