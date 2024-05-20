<?php

declare(strict_types=1);

namespace Ock\Ock\TextLookup;

use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

/**
 * Helper object to provide labels in bulk.
 */
class TextLookup_EllipsisIfDecorator implements TextLookupInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\TextLookup\TextLookupInterface $decorated
   * @param callable(string|int): bool $idNeedsEllipsis
   */
  public function __construct(
    private readonly TextLookupInterface $decorated,
    private readonly mixed $idNeedsEllipsis,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function idGetText(int|string $id): ?TextInterface {
    $text = $this->decorated->idGetText($id);
    if ($text === NULL) {
      return NULL;
    }
    if (($this->idNeedsEllipsis)($id)) {
      $text = Text::sprintf('%s…', $text);
    }
    return $text;
  }

}
