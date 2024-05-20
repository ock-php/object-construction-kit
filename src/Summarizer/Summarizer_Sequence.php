<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Attribute\Parameter\UniversalAdapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Formula\Sequence\Formula_SequenceInterface;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

class Summarizer_Sequence implements SummarizerInterface {

  /**
   * @param \Ock\Ock\Formula\Sequence\Formula_SequenceInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Summarizer\Summarizer_Sequence|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
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
   * @param \Ock\Ock\Summarizer\SummarizerInterface $itemSummarizer
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
