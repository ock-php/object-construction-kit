<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Group;

interface V2V_GroupInterface {

  /**
   * @param string[] $itemsPhp
   * @param mixed[] $conf
   *
   * @return string
   *
   * @throws \Ock\Ock\Exception\GeneratorException
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string;

}
