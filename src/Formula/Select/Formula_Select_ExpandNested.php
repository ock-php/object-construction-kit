<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Select;

use Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface;
use Ock\Ock\Formula\DrilldownVal\Formula_DrilldownValInterface;
use Ock\Ock\Formula\Id\Formula_IdInterface;
use Ock\Ock\IdToFormula\IdToFormulaInterface;
use Ock\Ock\Text\TextInterface;

class Formula_Select_ExpandNested implements Formula_SelectInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Select\Formula_SelectInterface $decorated
   * @param \Ock\Ock\IdToFormula\IdToFormulaInterface<\Ock\Ock\Core\Formula\FormulaInterface> $idToFormula
   */
  public function __construct(
    private readonly Formula_SelectInterface $decorated,
    private readonly IdToFormulaInterface $idToFormula
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getOptionsMap(): array {
    $map = [];
    foreach ($this->decorated->getOptionsMap() as $decoratedId => $decoratedGroupId) {
      $subFormula = $this->idGetSelectFormula($decoratedId);
      if ($subFormula === NULL) {
        $map[$decoratedId] = $decoratedGroupId;
      }
      else {
        foreach ($subFormula->getOptionsMap() as $inlineId => $inlineGroupId) {
          $map["$decoratedId/$inlineId"] = "$decoratedId/$inlineGroupId";
        }
      }
    }
    return $map;
  }

  /**
   * {@inheritdoc}
   */
  public function groupIdGetLabel(int|string $groupId): ?TextInterface {
    if (!is_string($groupId) || !str_contains($groupId, '/')) {
      return $this->decorated->groupIdGetLabel($groupId);
    }
    [$decoratedId, $inlineGroupId] = explode('/', $groupId, 2);
    if (NULL === $subFormula = $this->idGetSelectFormula($decoratedId)) {
      return NULL;
    }
    return $subFormula->groupIdGetLabel($inlineGroupId);
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {
    if (!is_string($id) || !str_contains($id, '/')) {
      return $this->decorated->idGetLabel($id);
    }
    [$prefix, $suffix] = explode('/', $id, 2);
    if (NULL === $subFormula = $this->idGetSelectFormula($prefix)) {
      return NULL;
    }
    return $subFormula->idGetLabel($suffix);
  }

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(string|int $id): bool {
    if (!str_contains((string) $id, '/')) {
      return $this->decorated->idIsKnown($id);
    }
    [$prefix, $suffix] = explode('/', (string) $id, 2);
    if (NULL === $subFormula = $this->idGetSelectFormula($prefix)) {
      return FALSE;
    }
    return $subFormula->idIsKnown($suffix);
  }

  /**
   * @param string|int $id
   *
   * @return \Ock\Ock\Formula\Select\Formula_SelectInterface|null
   * @throws \Ock\Ock\Exception\FormulaException
   */
  private function idGetSelectFormula(string|int $id): ?Formula_SelectInterface {

    if (NULL === $idFormula = $this->idGetIdFormula($id)) {
      return NULL;
    }

    if (!$idFormula instanceof Formula_SelectInterface) {
      return NULL;
    }

    return $idFormula;
  }

  /**
   * @param string|int $id
   *
   * @return \Ock\Ock\Formula\Id\Formula_IdInterface|null
   * @throws \Ock\Ock\Exception\FormulaException
   */
  private function idGetIdFormula(string|int $id): ?Formula_IdInterface {

    if (NULL === $nestedFormula = $this->idToFormula->idGetFormula($id)) {
      return NULL;
    }

    if ($nestedFormula instanceof Formula_DrilldownInterface) {
      return $nestedFormula->getIdFormula();
    }

    if ($nestedFormula instanceof Formula_IdInterface) {
      return $nestedFormula;
    }

    if ($nestedFormula instanceof Formula_DrilldownValInterface) {
      return $nestedFormula->getDecorated()->getIdFormula();
    }

    return NULL;
  }

}
