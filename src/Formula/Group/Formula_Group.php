<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Group;

use Donquixote\Ock\Formula\Group\Item\GroupFormulaItemInterface;

class Formula_Group implements Formula_GroupInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Group\Item\GroupFormulaItemInterface[] $items
   */
  public function __construct(
    private readonly array $items,
  ) {
    // Validate item type.
    (static fn (GroupFormulaItemInterface... $items) => null)(...array_values($items));
  }

  /**
   * {@inheritdoc}
   */
  public function getItems(): array {
    return $this->items;
  }

}
