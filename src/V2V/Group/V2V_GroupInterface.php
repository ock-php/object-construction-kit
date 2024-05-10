<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\Group;

interface V2V_GroupInterface {

  /**
   * @param string[] $itemsPhp
   * @param array $conf
   *
   * @return string
   *
   * @throws \Donquixote\Ock\Exception\GeneratorException
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string;

}
