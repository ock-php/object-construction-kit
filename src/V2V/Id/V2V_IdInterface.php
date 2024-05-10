<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\Id;

interface V2V_IdInterface {

  /**
   * @param int|string $id
   *
   * @return string
   */
  public function idGetPhp(int|string $id): string;

}
