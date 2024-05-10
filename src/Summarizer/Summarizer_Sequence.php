<?php

declare(strict_types=1);

namespace Donquixote\Ock\Summarizer;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\Adaptism\Attribute\Parameter\UniversalAdapter;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Formula\Sequence\Formula_SequenceInterface;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

class Summarizer_Sequence implements SummarizerInterface {

  /**
   * @param \Donquixote\Ock\Formula\Sequence\Formula_SequenceInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Donquixote\Ock\Summarizer\Summarizer_Sequence|null
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function create(
    #[Adaptee] Formula_SequenceInterface $formula,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
  ): ?Summarizer_Sequence {
    $itemSummarizer = $universalAdapter->adapt(
      $formula->getItemFormula(),
      SummarizerInterface::class,
    );

    if (NULL === $itemSummarizer) {
      return NULL;
    }

    return new self($itemSummarizer);
  }

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Summarizer\SummarizerInterface $itemSummarizer
   */
  public function __construct(
    private readonly SummarizerInterface $itemSummarizer,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): ?TextInterface {

    if (!\is_array($conf)) {
      $conf = [];
    }

    $summary = Text::ol();
    foreach ($conf as $delta => $itemConf) {
      if ((string) (int) $delta !== (string) $delta || $delta < 0) {
        // Fail on non-numeric and negative keys.
        return Text::t('Noisy configuration.')
          ->wrapSprintf('(%s)');
      }
      $summary->add(
        $this->itemSummarizer->confGetSummary($itemConf)
        ?? Text::t('Undocumented item.')
          ->wrapSprintf('(%s)'),
      );
    }

    return $summary;
  }

}
