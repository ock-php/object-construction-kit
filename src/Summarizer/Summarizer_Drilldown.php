<?php

declare(strict_types=1);

namespace Donquixote\Ock\Summarizer;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\DrilldownKeysHelper\DrilldownKeysHelper;
use Donquixote\Ock\Formula\Drilldown\Formula_DrilldownInterface;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

#[Adapter]
class Summarizer_Drilldown implements SummarizerInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Drilldown\Formula_DrilldownInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
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

    if (NULL === $idLabel = $this->formula->getIdFormula()->idGetLabel($id)) {
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
