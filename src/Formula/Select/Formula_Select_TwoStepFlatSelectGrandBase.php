<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Select;

use Donquixote\Ock\Formula\Select\Flat\Formula_FlatSelectInterface;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

abstract class Formula_Select_TwoStepFlatSelectGrandBase implements Formula_SelectInterface {

  /**
   * {@inheritdoc}
   */
  public function getOptionsMap(): array {
    $map = [];
    foreach ($this->getIdFormula()->getOptions() as $groupId => $groupLabel) {
      if (NULL === $subFormula = $this->idGetSubFormula($groupId)) {
        continue;
      }
      foreach ($subFormula->getOptions() as $subId => $subLabel) {
        $combinedId = $this->combineIds($groupId, $subId);
        $map[$combinedId] = $groupId;
      }
    }
    return $map;
  }

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(string|int $id): bool {
    [$groupId, $subId] = $this->splitId($id) + [NULL, NULL];
    if (NULL === $subId) {
      return FALSE;
    }
    if (!$this->getIdFormula()->idIsKnown($groupId)) {
      return FALSE;
    }
    if (NULL === $subFormula = $this->idGetSubFormula($groupId)) {
      return FALSE;
    }
    return $subFormula->idIsKnown($subId);
  }

  /**
   * {@inheritdoc}
   */
  public function groupIdGetLabel(int|string $groupId): ?TextInterface {
    return $this->getIdFormula()->idGetLabel($groupId);
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {
    [$groupId, $subId] = $this->splitId($id) + [NULL, NULL];
    if (NULL === $subId) {
      return NULL;
    }
    if (NULL === $groupLabel = $this->getIdFormula()->idGetLabel($groupId)) {
      return NULL;
    }
    if (NULL === $subFormula = $this->idGetSubFormula($groupId)) {
      return NULL;
    }
    if (NULL === $subLabel = $subFormula->idGetLabel($subId)) {
      return NULL;
    }
    return $this->combineLabels($groupLabel, $subLabel);
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
    return explode(':', $combinedId, 2);
  }

  /**
   * @return \Donquixote\Ock\Formula\Select\Flat\Formula_FlatSelectInterface
   */
  abstract protected function getIdFormula(): Formula_FlatSelectInterface;

  /**
   * @param string $id
   *
   * @return \Donquixote\Ock\Formula\Select\Flat\Formula_FlatSelectInterface|null
   */
  abstract protected function idGetSubFormula(string $id): ?Formula_FlatSelectInterface;

}
