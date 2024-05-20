<?php

declare(strict_types=1);

namespace Ock\Ock\TextLookup;

use Ock\Ock\Text\TextInterface;

/**
 * Helper object to provide labels in bulk.
 */
class TextLookup_FallbackChain implements TextLookupInterface {

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
  public function idGetText(int|string $id): ?TextInterface {
    foreach ($this->lookups as $lookup) {
      $text = $lookup->idGetText($id);
      if ($text !== NULL) {
        return $text;
      }
    }
    return NULL;
  }

}
