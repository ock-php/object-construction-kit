<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Ock\Formula\Boolean\Formula_BooleanInterface;
use Ock\Ock\Text\TextInterface;

#[Adapter]
class Summarizer_Boolean implements SummarizerInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Boolean\Formula_BooleanInterface $formula
   */
  public function __construct(
    private readonly Formula_BooleanInterface $formula,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): ?TextInterface {

    $boolean = !empty($conf);

    return $boolean
      ? $this->formula->getTrueSummary()
      : $this->formula->getFalseSummary();
  }

}
