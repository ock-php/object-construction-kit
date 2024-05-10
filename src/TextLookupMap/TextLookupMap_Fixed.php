<?php

declare(strict_types=1);

namespace Donquixote\Ock\TextLookupMap;

use Donquixote\Ock\TextLookup\TextLookupInterface;

class TextLookupMap_Fixed implements TextLookupMapInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\TextLookup\TextLookupInterface[] $lookups
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
