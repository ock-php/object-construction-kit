<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Select;

use Donquixote\Ock\Text\TextInterface;

class Formula_Select_MergeMultiple implements Formula_SelectInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Select\Formula_SelectInterface[] $formulas
   */
  public function __construct(
    private readonly array $formulas,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {
    foreach ($this->formulas as $formula) {
      if (NULL !== $label = $formula->idGetLabel($id)) {
        return $label;
      }
    }
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(string|int $id): bool {
    foreach ($this->formulas as $formula) {
      if ($formula->idIsKnown($id)) {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getOptionsMap(): array {
    $map = [];
    foreach ($this->formulas as $formula) {
      foreach ($formula->getOptionsMap() as $id => $groupId) {
        $map[$id] = $groupId;
      }
    }
    return $map;
  }

  /**
   * {@inheritdoc}
   */
  public function groupIdGetLabel(int|string $groupId): ?TextInterface {
    foreach ($this->formulas as $formula) {
      if (NULL !== $groupLabel = $formula->groupIdGetLabel($groupId)) {
        return $groupLabel;
      }
    }
    return NULL;
  }

}
