<?php

declare(strict_types=1);

namespace Donquixote\Ock\Summarizer;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\Adaptism\Attribute\Parameter\UniversalAdapter;
use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\DID\Attribute\Parameter\GetService;
use Donquixote\Ock\Formula\Iface\Formula_IfaceInterface;
use Donquixote\Ock\Plugin\Map\PluginMapInterface;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

#[Adapter]
class Summarizer_Iface implements SummarizerInterface {

  /**
   * @var string
   */
  private string $type;

  /**
   * @var bool
   */
  private bool $allowsNull;

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Iface\Formula_IfaceInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   * @param \Donquixote\Ock\Plugin\Map\PluginMapInterface $pluginMap
   */
  public function __construct(
    #[Adaptee]
    Formula_IfaceInterface $formula,
    #[UniversalAdapter]
    private readonly UniversalAdapterInterface $universalAdapter,
    #[GetService]
    private readonly PluginMapInterface $pluginMap,
  ) {
    $this->type = $formula->getInterface();
    $this->allowsNull = $formula->allowsNull();
  }

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): TextInterface {
    $id = $conf['id'] ?? NULL;
    $subConf = $conf['options'] ?? NULL;
    $decoratorsConf = $conf['decorators'] ?? [];

    if ($id === NULL) {
      if ($this->allowsNull) {
        return Text::t('None')
          ->wrapSprintf('- %s -');
      }
      return Text::t('Missing')
        ->wrapSprintf('- %s -');
    }

    $plugins = $this->pluginMap->typeGetPlugins($this->type);
    $plugin = $plugins[$id] ?? NULL;

    if ($plugin === NULL) {
      return Text::s($id)
        ->wrapT('@id', 'Unknown id "@id"')
        ->wrapSprintf('- %s -');
    }

    $subFormula = $plugin->getFormula();

    $summary = $plugin->getLabel();

    try {
      $subSummarizer = Summarizer::fromFormula(
        $subFormula,
        $this->universalAdapter,
      );
    }
    catch (AdapterException) {
      return Text::s((string) $id)
        ->wrapT('@id', 'Undocumented id "@id"')
        ->wrapSprintf('- %s -');
    }

    $subSummary = $subSummarizer->confGetSummary($subConf);

    if ($subSummary !== NULL) {
      $summary = Text::label($summary, $subSummary);
    }

    if (!$decoratorsConf) {
      return $summary;
    }

    $decoSummarizer = clone $this;
    $decoSummarizer->type = 'decorator<' . $this->type . '>';
    $decoSummarizer->allowsNull = FALSE;

    $decoSummaries = [];
    foreach ($decoratorsConf as $decoratorConf) {
      $decoSummaries[] = $decoSummarizer->confGetSummary($decoratorConf);
    }

    return Text::ul([
      Text::label(
        Text::t('Plugin'),
        $summary,
      ),
      (count($decoSummaries) === 1)
        ? Text::label(
        Text::t('Decorator'),
        reset($decoSummaries),
      )
        : Text::label(
        Text::t('Decorators'),
        Text::ul($decoSummaries),
      ),
    ]);
  }

}
