<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Ock\Text\TextInterface;

interface SummarizerInterface {

  /**
   * @param mixed $conf
   *
   * @return null|\Ock\Ock\Text\TextInterface
   *
   * @throws \Ock\Ock\Exception\SummarizerException
   */
  public function confGetSummary(mixed $conf): ?TextInterface;

}
