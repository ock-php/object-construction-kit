<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Drilldown;

interface V2V_DrilldownInterface {

  /**
   * @param int|string $id
   * @param string $php
   *
   * @return mixed
   */
  public function idPhpGetPhp(int|string $id, string $php): mixed;

}
