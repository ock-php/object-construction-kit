<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Select;

use Donquixote\Ock\TextLookup\TextLookupInterface;

/**
 * Select formula using TextLookup* objects for option labels and group labels.
 */
class Formula_Select_LabelLookupFixed extends Formula_Select_LabelLookupBase {

  /**
   * Constructor.
   *
   * @param array<string, string> $optionsMap
   *   Format: $[$id] = $groupId.
   * @param \Donquixote\Ock\TextLookup\TextLookupInterface $labelLookup
   * @param \Donquixote\Ock\TextLookup\TextLookupInterface $groupLabelLookup
   */
  public function __construct(
    private readonly array $optionsMap,
    TextLookupInterface $labelLookup,
    TextLookupInterface $groupLabelLookup,
  ) {
    parent::__construct($labelLookup, $groupLabelLookup);
  }

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(string|int $id): bool {
    return isset($this->optionsMap[$id]);
  }

  /**
   * {@inheritdoc}
   */
  public function getOptionsMap(): array {
    return $this->optionsMap;
  }

}
