<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Select;

use Donquixote\Ock\Text\TextInterface;
use Donquixote\Ock\TextLookup\TextLookupInterface;

/**
 * Select formula using TextLookup* objects for option labels and group labels.
 */
abstract class Formula_Select_LabelLookupBase implements Formula_SelectInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\TextLookup\TextLookupInterface $labelLookup
   * @param \Donquixote\Ock\TextLookup\TextLookupInterface $groupLabelLookup
   */
  public function __construct(
    private readonly TextLookupInterface $labelLookup,
    private readonly TextLookupInterface $groupLabelLookup,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {
    return $this->idIsKnown($id)
      ? $this->labelLookup->idGetText($id)
      : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function groupIdGetLabel(int|string $groupId): ?TextInterface {
    return $this->groupLabelLookup->idGetText($groupId);
  }

}
