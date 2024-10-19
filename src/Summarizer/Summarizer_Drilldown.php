<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\DrilldownKeysHelper\DrilldownKeysHelper;
use Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface;
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

    if (NULL === $id) {
      return Text::t('None')
        ->wrapSprintf('- %s -');
    }

    if (NULL === $subFormula = $this->formula->getIdToFormula()->idGetFormula($id)) {
      return Text::s($id)
        ->wrapT('@id', 'Unknown id "@id"')
        ->wrapSprintf('- %s -');
    }

    $idFormula = $this->formula->getIdFormula();
    if (NULL === $idLabel = $idFormula->idGetLabel($id)) {
      return Text::s($id)
        ->wrapT('@id', 'Unnamed id "@id"')
        ->wrapSprintf('- %s -');
    }

    try {
      $subSummarizer = Summarizer::fromFormula(
        $subFormula,
        $this->universalAdapter);
    }
    catch (AdapterException) {
      return Text::s((string) $id)
        ->wrapT('@id', 'Undocumented id "@id"')
        ->wrapSprintf('- %s -');
    }

    $subSummary = $subSummarizer->confGetSummary($subConf);

    if ($subSummary === NULL) {
      return $idLabel;
    }

    // @todo Show just the label if subSummary produces empty string?
    return Text::label($idLabel, $subSummary);
  }

}
