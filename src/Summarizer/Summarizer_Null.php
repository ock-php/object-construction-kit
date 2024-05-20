<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Ock\Text\TextInterface;

class Summarizer_Null implements SummarizerInterface {

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): ?TextInterface {
    return NULL;
  }

}
