<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Group;

class V2V_Group_ExtraExpressions implements V2V_GroupInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\V2V\Group\V2V_GroupInterface $decorated
   * @param \Ock\Ock\V2V\Group\V2V_GroupInterface[] $extraExpressions
   */
  public function __construct(
    private readonly V2V_GroupInterface $decorated,
    private readonly array $extraExpressions,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
    foreach ($this->extraExpressions as $key => $v2v) {
      $itemsPhp[$key] = $v2v->itemsPhpGetPhp($itemsPhp, $conf);
    }
    return $this->decorated->itemsPhpGetPhp($itemsPhp, $conf);
  }

}
