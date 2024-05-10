<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SelectOld;

use Donquixote\Ock\Text\TextInterface;

class Formula_Select_MergeMultiple extends Formula_Select_BufferedBase {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\SelectOld\Formula_SelectInterface[] $formulas
   */
  public function __construct(
    private readonly array $formulas,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {
    foreach ($this->formulas as $formula) {
      $label = $formula->idGetLabel($id);
      if ($label !== NULL) {
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
  protected function initialize(array &$grouped_options, array &$group_labels): void {
    foreach ($this->formulas as $formula) {
      foreach ($formula->getOptGroups() as $group_id => $group_label) {
        $group_labels[$group_id] = $group_label;
        foreach ($formula->getOptions($group_id) as $id => $label) {
          $grouped_options[$group_id][$id] = $label;
        }
      }
    }
  }

}
