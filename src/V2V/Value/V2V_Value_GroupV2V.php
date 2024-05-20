<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Value;

use Ock\Ock\V2V\Group\V2V_GroupInterface;

class V2V_Value_GroupV2V implements V2V_ValueInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\V2V\Group\V2V_GroupInterface $groupV2V
   * @param string $key
   */
  public function __construct(
    private readonly V2V_GroupInterface $groupV2V,
    private readonly string $key,
  ) {}

  /**
   * {@inheritdoc}
   * @param mixed $conf
   */
  public function phpGetPhp(string $php, mixed $conf): string {
    return $this->groupV2V->itemsPhpGetPhp([$this->key => $php], [$this->key => $conf]);
  }

}
