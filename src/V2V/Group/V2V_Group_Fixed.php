<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Group;

class V2V_Group_Fixed implements V2V_GroupInterface {

  /**
   * Constructor.
   *
   * @param string $php
   */
  public function __construct(
    private readonly string $php,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
    return $this->php;
  }

}
