<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SelectOld;

use Donquixote\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

abstract class Formula_Select_TwoStepFlatSelectGrandBase implements Formula_SelectInterface {

  /**
   * {@inheritdoc}
   */
  public function getOptGroups(): array {
    return $this->getIdFormula()->getOptions();
  }

  /**
   * {@inheritdoc}
   */
  public function getOptions(?string $group_id): array {
    $subFormula = $this->idGetSubFormula($group_id);
    if ($subFormula === NULL) {
      return [];
    }
    $group_label = $this->getIdFormula()->idGetLabel($group_id)
      ?? Text::s($group_id);
    $options = [];
    foreach ($subFormula->getOptions() as $sub_id => $sub_label) {
      $combinedId = $this->combineIds($group_id, $sub_id);
      $options[$group_id][$combinedId] = $this->combineLabels($group_label, $sub_label);
    }
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(string|int $id): bool {
    [$id0, $id1] = $this->splitId($id) + [NULL, NULL];

    if (NULL === $id1) {
      return FALSE;
    }

    if (!$this->getIdFormula()->idIsKnown($id0)) {
      return FALSE;
    }

    if (NULL === $subFormula = $this->idGetSubFormula($id0)) {
      return FALSE;
    }

    return $subFormula->idIsKnown($id1);
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {
    [$id0, $id1] = $this->splitId($id) + [NULL, NULL];

    if (NULL === $id1) {
      return NULL;
    }

    if (NULL === $label0 = $this->getIdFormula()->idGetLabel($id0)) {
      return NULL;
    }

    if (NULL === $subFormula = $this->idGetSubFormula($id0)) {
      return NULL;
    }

    if (NULL === $label1 = $subFormula->idGetLabel($id1)) {
      return NULL;
    }

    return $this->combineLabels($label0, $label1);
  }

  /**
   * @param \Donquixote\Ock\Text\TextInterface $label0
   * @param \Donquixote\Ock\Text\TextInterface $label1
   *
   * @return \Donquixote\Ock\Text\TextInterface
   */
  protected function combineLabels(TextInterface $label0, TextInterface $label1): TextInterface {
    return Text::concat([$label0, $label1], ' - ');
  }

  /**
   * @param string $id0
   * @param string $id1
   *
   * @return string
   */
  protected function combineIds(string $id0, string $id1): string {
    return $id0 . ':' . $id1;
  }

  /**
   * @param string $combinedId
   *
   * @return string[]
   *   Format: [$id0, $id1]
   */
  protected function splitId(string $combinedId): array {
    return explode(':', $combinedId);
  }

  /**
   * @return \Donquixote\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface
   */
  abstract protected function getIdFormula(): Formula_FlatSelectInterface;

  /**
   * @param string $id
   *
   * @return \Donquixote\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface|null
   */
  abstract protected function idGetSubFormula(string $id): ?Formula_FlatSelectInterface;

}
