<?php

declare(strict_types=1);

namespace Donquixote\Ock\Summarizer;

use Donquixote\Ock\Text\TextInterface;

class Summarizer_Null implements SummarizerInterface {

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): ?TextInterface {
    return NULL;
  }

}
