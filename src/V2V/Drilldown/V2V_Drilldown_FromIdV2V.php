<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\Drilldown;

use Donquixote\Ock\V2V\Id\V2V_IdInterface;

class V2V_Drilldown_FromIdV2V implements V2V_DrilldownInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\V2V\Id\V2V_IdInterface $v2vId
   */
  public function __construct(
    private readonly V2V_IdInterface $v2vId,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function idPhpGetPhp(int|string $id, string $php): string {
    return $this->v2vId->idGetPhp($id);
  }

}
