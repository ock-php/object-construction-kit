<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\Group;

class V2V_Group_ExtraExpressions implements V2V_GroupInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\V2V\Group\V2V_GroupInterface $decorated
   * @param \Donquixote\Ock\V2V\Group\V2V_GroupInterface[] $extraExpressions
   */
  public function __construct(
    private readonly V2V_GroupInterface $decorated,
    private readonly array $extraExpressions,
  ) {}

  /**
   * {@inheritdoc}
   * @param array $conf
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
    foreach ($this->extraExpressions as $key => $v2v) {
      $itemsPhp[$key] = $v2v->itemsPhpGetPhp($itemsPhp, $conf);
    }
    return $this->decorated->itemsPhpGetPhp($itemsPhp, $conf);
  }

}
