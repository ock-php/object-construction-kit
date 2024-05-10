<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\Value;

use Donquixote\Ock\V2V\Drilldown\V2V_DrilldownInterface;

class V2V_Value_DrilldownFixedId implements V2V_ValueInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\V2V\Drilldown\V2V_DrilldownInterface $v2vDrilldown
   * @param string|int $id
   */
  public function __construct(
    private readonly V2V_DrilldownInterface $v2vDrilldown,
    private readonly string|int $id,
  ) {}

  /**
   * {@inheritdoc}
   * @param mixed $conf
   */
  public function phpGetPhp(string $php, mixed $conf): string {
    return $this->v2vDrilldown->idPhpGetPhp($this->id, $php);
  }

}
