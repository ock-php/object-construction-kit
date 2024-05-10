<?php

declare(strict_types=1);

namespace Donquixote\Ock\TextLookup;

use Donquixote\Ock\Text\TextInterface;

/**
 * Helper object to provide labels in bulk.
 */
class TextLookup_Fixed implements TextLookupInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Text\TextInterface[] $labels
   */
  public function __construct(
    private readonly array $labels,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function idGetText(int|string $id): ?TextInterface {
    return $this->labels[$id] ?? NULL;
  }

}
