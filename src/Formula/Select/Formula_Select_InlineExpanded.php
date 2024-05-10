<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Select;

use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Formula\Id\Formula_IdInterface;
use Donquixote\Ock\IdToFormula\IdToFormulaInterface;
use Donquixote\Ock\InlineDrilldown\InlineDrilldownInterface;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

class Formula_Select_InlineExpanded implements Formula_SelectInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Select\Formula_SelectInterface $decorated
   * @param \Donquixote\Ock\IdToFormula\IdToFormulaInterface $idToFormula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   */
  public function __construct(
    private readonly Formula_SelectInterface $decorated,
    private readonly IdToFormulaInterface $idToFormula,
    private readonly UniversalAdapterInterface $universalAdapter,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getOptionsMap(): array {
    $map = [];
    foreach ($this->decorated->getOptionsMap() as $id => $groupId) {
      $inlineFormula = $this->idGetSelectFormula($id);
      if ($inlineFormula !== null) {
        foreach ($inlineFormula->getOptionsMap() as $inlineId => $inlineGroupId) {
          // Ignore groups from the inline selects.
          $map["$id/$inlineId"] = $groupId;
        }
      }
      $map[$id] = $groupId;
    }
    return $map;
  }

  public function groupIdGetLabel(int|string $groupId): ?TextInterface {
    // Ignore groups from the inline selects.
    return $this->decorated->groupIdGetLabel($groupId);
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {
    if (!str_contains((string) $id, '/')) {
      return $this->decorated->idGetLabel($id);
    }
    [$decoratedId, $inlineId] = explode('/', $id, 2);
    if (NULL === $decoratedLabel = $this->decorated->idGetLabel($decoratedId)) {
      return NULL;
    }
    if (NULL === $subFormula = $this->idGetSelectFormula($decoratedId)) {
      return NULL;
    }
    if (NULL === $inlineLabel = $subFormula->idGetLabel($inlineId)) {
      return NULL;
    }
    return Text::label($decoratedLabel, $inlineLabel);
  }

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(string|int $id): bool {

    if (!\str_contains((string) $id, '/')) {
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
   * @return \Donquixote\Ock\Formula\Select\Formula_SelectInterface|null
   * @throws \Donquixote\Ock\Exception\FormulaException
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
   * @return \Donquixote\Ock\Formula\Id\Formula_IdInterface|null
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  private function idGetIdFormula(string|int $id): ?Formula_IdInterface {
    if (NULL === $nestedFormula = $this->idToFormula->idGetFormula($id)) {
      // This id has no children.
      return NULL;
    }

    try {
      return $this->universalAdapter->adapt(
        $nestedFormula,
        InlineDrilldownInterface::class,
      )?->getIdFormula();
    }
    catch (AdapterException) {
      // @todo Log this.
      return NULL;
    }
  }

}
