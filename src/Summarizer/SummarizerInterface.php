<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Ock\Text\TextInterface;

/**
 * Produces a html summary for a given configuration.
 */
interface SummarizerInterface {

  /**
   * Gets a summary for given configuration.
   *
   * @param mixed $conf
   *   Configuration to summarize.
   *
   * @return null|\Ock\Ock\Text\TextInterface
   *   The summary as html text.
   *
   * @throws \Ock\Ock\Exception\SummarizerException
   *   No summary can be built for this configuration.
   */
  public function confGetSummary(mixed $conf): ?TextInterface;

}
