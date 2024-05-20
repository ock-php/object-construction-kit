<?php

declare(strict_types=1);

namespace Ock\Ock\DrilldownOptionsByType;

class DrilldownOptionsByType_Fixed implements DrilldownOptionsByTypeInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Drilldown\Option\DrilldownOptionInterface[][] $optionss
   */
  public function __construct(
    private readonly array $optionss,
  ) {}

  /**
   * Gets drilldown options by type.
   *
   * @return \Ock\Ock\Formula\Drilldown\Option\DrilldownOptionInterface[][]
   *   Format: $[$type][$id] = $option.
   */
  public function getDrilldownOptionsByType(): array {
    return $this->optionss;
  }

}
