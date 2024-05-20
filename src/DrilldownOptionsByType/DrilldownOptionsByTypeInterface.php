<?php

declare(strict_types=1);

namespace Ock\Ock\DrilldownOptionsByType;

interface DrilldownOptionsByTypeInterface {

  /**
   * Gets drilldown options by type.
   *
   * @return \Ock\Ock\Formula\Drilldown\Option\DrilldownOptionInterface[][]
   *   Format: $[$type][$id] = $option.
   */
  public function getDrilldownOptionsByType(): array;

}
