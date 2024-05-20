<?php

declare(strict_types=1);

namespace Ock\Ock\TextLookup;

use Ock\Ock\Text\TextInterface;

/**
 * Helper object to provide labels in bulk.
 */
class TextLookup_Fixed implements TextLookupInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Text\TextInterface[] $labels
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
