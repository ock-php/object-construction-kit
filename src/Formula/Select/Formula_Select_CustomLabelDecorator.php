<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Select;

use Donquixote\Ock\Text\TextInterface;
use Donquixote\Ock\TextLookup\TextLookupInterface;

/**
 * @todo Maybe "Options" should be renamed to "Choice"?
 */
class Formula_Select_CustomLabelDecorator implements Formula_SelectInterface {

  /**
   * @var \Donquixote\Ock\TextLookup\TextLookupInterface|null
   */
  private ?TextLookupInterface $labelLookup = NULL;

  /**
   * @var \Donquixote\Ock\TextLookup\TextLookupInterface|null
   */
  private ?TextLookupInterface $groupLabelLookup = NULL;

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Select\Formula_SelectInterface $decorated
   */
  public function __construct(
    private readonly Formula_SelectInterface $decorated,
  ) {}

  /**
   * @param \Donquixote\Ock\TextLookup\TextLookupInterface $textLookup
   *
   * @return static
   */
  public function withCustomLabelLookup(TextLookupInterface $textLookup): static {
    $clone = clone $this;
    $clone->labelLookup = $textLookup;
    return $clone;
  }

  /**
   * @param \Donquixote\Ock\TextLookup\TextLookupInterface $textLookup
   *
   * @return static
   */
  public function withCustomGroupLabelLookup(TextLookupInterface $textLookup): static {
    $clone = clone $this;
    $clone->groupLabelLookup = $textLookup;
    return $clone;
  }

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(int|string $id): bool {
    return $this->decorated->idIsKnown($id);
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(int|string $id): ?TextInterface {
    return $this->labelLookup?->idGetText($id)
      ?? $this->decorated->idGetLabel($id);
  }

  /**
   * {@inheritdoc}
   */
  public function getOptionsMap(): array {
    return $this->decorated->getOptionsMap();
  }

  /**
   * {@inheritdoc}
   */
  public function groupIdGetLabel(int|string $groupId): ?TextInterface {
    return $this->groupLabelLookup?->idGetText($groupId)
      ?? $this->decorated->groupIdGetLabel($groupId);
  }

}
