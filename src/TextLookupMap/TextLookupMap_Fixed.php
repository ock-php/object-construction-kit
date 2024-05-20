<?php

declare(strict_types=1);

namespace Ock\Ock\TextLookupMap;

use Ock\Ock\TextLookup\TextLookupInterface;

class TextLookupMap_Fixed implements TextLookupMapInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\TextLookup\TextLookupInterface[] $lookups
   */
  public function __construct(
    private readonly array $lookups,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function idGetTextLookup(string $id): ?TextLookupInterface {
    return $this->lookups[$id] ?? NULL;
  }

}
