<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\SelectOld;

use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Formula\Id\Formula_IdInterface;
use Ock\Ock\IdToFormula\IdToFormulaInterface;
use Ock\Ock\InlineDrilldown\InlineDrilldownInterface;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

class Formula_Select_InlineExpanded extends Formula_Select_BufferedBase {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\SelectOld\Formula_SelectInterface $decorated
   * @param \Ock\Ock\IdToFormula\IdToFormulaInterface<\Ock\Ock\Core\Formula\FormulaInterface> $idToFormula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @phpstan-ignore parameter.deprecatedInterface
   */
  public function __construct(
    private readonly Formula_SelectInterface $decorated,
    private readonly IdToFormulaInterface $idToFormula,
    private readonly UniversalAdapterInterface $universalAdapter,
  ) {}

  /**
   * {@inheritdoc}
   */
  protected function initialize(array &$grouped_options, array &$group_labels): void {
    foreach (['' => NULL] + $this->decorated->getOptGroups() as $group_id => $group_label) {
      foreach ($this->decorated->getOptions($group_id) as $id => $label) {
        $inline_formula = $this->idGetSelectFormula($id);
        if ($inline_formula === NULL) {
          $grouped_options[$group_id][$id] = $label;
          if ($group_label !== NULL) {
            $group_labels[$group_id] = $group_label;
          }
        }
        else {
          foreach (['' => NULL] + $inline_formula->getOptGroups() as $inline_group_id => $inline_group_label) {
            foreach ($inline_formula->getOptions($inline_group_id) as $inline_id => $inline_label) {
              $grouped_options[$inline_group_id]["$id/$inline_id"] = Text::label(
                $label,
                $inline_label);
            }
          }
          $grouped_options[$group_id][$id] = Text::fluent($label)
            ->wrapT('@label', '@label - ALL');
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {

    if (!str_contains((string) $id, '/')) {
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
   * @return \Ock\Ock\Formula\SelectOld\Formula_SelectInterface|null
   * @throws \Ock\Ock\Exception\FormulaException
   *
   * @phpstan-ignore return.deprecatedInterface
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
