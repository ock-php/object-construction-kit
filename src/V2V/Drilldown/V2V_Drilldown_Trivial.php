<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Drilldown;

class V2V_Drilldown_Trivial implements V2V_DrilldownInterface {

  /**
   * {@inheritdoc}
   */
  public function idPhpGetPhp(int|string $id, string $php): string {
    return $php;
  }

}
