<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Group;

class Formula_Group_Empty implements Formula_GroupInterface {

  /**
   * {@inheritdoc}
   */
  public function getItems(): array {
    return [];
  }

}
