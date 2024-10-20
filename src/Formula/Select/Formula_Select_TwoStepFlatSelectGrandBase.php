<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Select;

use Ock\Ock\Formula\Select\Flat\Formula_FlatSelectInterface;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

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
    [$groupId, $subId] = $this->splitId($id);
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
    [$groupId, $subId] = $this->splitId($id);
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
   * @param \Ock\Ock\Text\TextInterface $label0
   * @param \Ock\Ock\Text\TextInterface $label1
   *
   * @return \Ock\Ock\Text\TextInterface
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
   * @param string|int $combinedId
   *
   * @return array{string, string|null}
   *   Format: [$id0, $id1]
   */
  protected function splitId(string|int $combinedId): array {
    // @phpstan-ignore return.type
    return explode(':', (string) $combinedId, 2) + [null, null];
  }

  /**
   * @return \Ock\Ock\Formula\Select\Flat\Formula_FlatSelectInterface
   */
  abstract protected function getIdFormula(): Formula_FlatSelectInterface;

  /**
   * @param string $id
   *
   * @return \Ock\Ock\Formula\Select\Flat\Formula_FlatSelectInterface|null
   */
  abstract protected function idGetSubFormula(string $id): ?Formula_FlatSelectInterface;

}
