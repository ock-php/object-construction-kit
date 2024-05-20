<?php

declare(strict_types=1);

namespace Ock\Ock\DrilldownOptionsByType;

class DrilldownOptionsByType_Buffer implements DrilldownOptionsByTypeInterface {

  /**
   * @var \Ock\Ock\Formula\Drilldown\Option\DrilldownOptionInterface[][]|null
   */
  private ?array $buffer = null;

  /**
   * Constructor.
   *
   * @param \Ock\Ock\DrilldownOptionsByType\DrilldownOptionsByTypeInterface $decorated
   */
  public function __construct(
    private readonly DrilldownOptionsByTypeInterface $decorated,
  ) {}

  /**
   * Gets drilldown options by type.
   *
   * @return \Ock\Ock\Formula\Drilldown\Option\DrilldownOptionInterface[][]
   *   Format: $[$type][$id] = $option.
   */
  public function getDrilldownOptionsByType(): array {
    return $this->buffer
      ??= $this->decorated->getDrilldownOptionsByType();
  }

}
