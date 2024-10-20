<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Formula\Label\Formula_LabelInterface;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

/**
 * Decorator that prepends a "<label>: " to a summary.
 */
class Summarizer_Label implements SummarizerInterface {

  /**
   * @param \Ock\Ock\Formula\Label\Formula_LabelInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Summarizer\SummarizerInterface|null
   */
  #[Adapter]
  public static function create(Formula_LabelInterface $formula, UniversalAdapterInterface $universalAdapter): ?SummarizerInterface {
    try {
      $decorated = Summarizer::fromFormula(
        $formula->getDecorated(),
        $universalAdapter);
    }
    catch (AdapterException) {
      return NULL;
    }
    $label = $formula->getLabel();
    if ($label === null) {
      return $decorated;
    }
    return new self($decorated, $label);
  }

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Summarizer\SummarizerInterface $decorated
   * @param \Ock\Ock\Text\TextInterface $label
   */
  public function __construct(
    private readonly SummarizerInterface $decorated,
    private readonly TextInterface $label,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): ?TextInterface {
    $decorated = $this->decorated->confGetSummary($conf);
    if ($decorated === null) {
      return null;
    }
    return Text::label($this->label, $decorated);
  }

}
