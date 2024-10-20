<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Drilldown;

/**
 * See method doc.
 */
interface V2V_DrilldownInterface {

  /**
   * Transforms a value expression from a drilldown formula.
   *
   * @param int|string $id
   *   Id that was chosen with the drilldown formula.
   * @param string $php
   *   Value expression from the sub-formula with the sub-configuration.
   *
   * @return mixed
   *   Transformed value expression.
   */
  public function idPhpGetPhp(int|string $id, string $php): mixed;

}
