<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Select;

use Ock\Ock\Text\TextInterface;
use Ock\Ock\TextLookup\TextLookupInterface;

/**
 * Select formula using TextLookup* objects for option labels and group labels.
 */
abstract class Formula_Select_LabelLookupBase implements Formula_SelectInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\TextLookup\TextLookupInterface $labelLookup
   * @param \Ock\Ock\TextLookup\TextLookupInterface $groupLabelLookup
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
