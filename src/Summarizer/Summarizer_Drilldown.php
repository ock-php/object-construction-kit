<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\DrilldownKeysHelper\DrilldownKeysHelper;
use Ock\Ock\Exception\FormulaException;
use Ock\Ock\Exception\SummarizerException;
use Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface;
use Ock\Ock\Formula\IdToLabel\Formula_IdToLabelInterface;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

#[Adapter]
class Summarizer_Drilldown implements SummarizerInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   */
  public function __construct(
    private readonly Formula_DrilldownInterface $formula,
    private readonly UniversalAdapterInterface $universalAdapter
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): ?TextInterface {

    [$id, $subConf] = DrilldownKeysHelper::fromFormula($this->formula)
      ->unpack($conf);

    if ($id === null) {
      // The configuration is empty / no plugin is chosen.
      return Text::t('None')
        ->wrapSprintf('- %s -');
    }

    $idFormula = $this->formula->getIdFormula();

    try {
      if (!$idFormula->idIsKnown($id)) {
        return Text::s((string) $id)
          ->wrapT('@id', 'Unknown id "@id"')
          ->wrapSprintf('- %s -');
      }
      $idToLabel = $this->universalAdapter->adapt($idFormula, Formula_IdToLabelInterface::class);
      if ($idToLabel === null) {
        $idLabel = Text::s((string) $id)
          ->wrapT('@id', 'Id "@id"')
          ->wrapSprintf('- %s -');
      }
      else {
        $idLabel = $idToLabel->idGetLabel($id);
        if ($idLabel === null) {
          $idLabel = Text::s((string) $id)
            ->wrapT('@id', 'Unnamed id "@id"')
            ->wrapSprintf('- %s -');
        }
      }
      $subFormula = $this->formula->getIdToFormula()->idGetFormula($id);
      if ($subFormula === null) {
        // This is unexpected: The id is known for the id formula, but not when
        // requesting the sub-formula.
        return Text::s((string) $id)
          // For now just make sure the text is different.
          ->wrapT('@id', 'Unavailable id "@id"')
          ->wrapSprintf('- %s -');
      }
      $subSummarizer = Summarizer::fromFormula(
        $subFormula,
        $this->universalAdapter,
      );
    }
    catch (AdapterException|FormulaException $e) {
      throw new SummarizerException(sprintf('Formula or adapter malfunction for id %s.', $id), previous: $e);
    }

    $subSummary = $subSummarizer->confGetSummary($subConf);

    if ($subSummary === NULL) {
      return $idLabel;
    }

    // @todo Show just the label if subSummary produces empty string?
    return Text::label($idLabel, $subSummary);
  }

}
