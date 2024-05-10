<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\Group;

class V2V_Group_Pick implements V2V_GroupInterface {

  /**
   * Constructor.
   *
   * @param string $key
   */
  public function __construct(
    private readonly string $key,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
    return $itemsPhp[$this->key];
  }

}
