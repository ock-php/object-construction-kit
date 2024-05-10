<?php

declare(strict_types=1);

namespace Donquixote\Ock\Summarizer;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Formula\Optional\Formula_OptionalInterface;
use Donquixote\Ock\Text\TextInterface;

class Summarizer_Optional implements SummarizerInterface {

  /**
   * @param \Donquixote\Ock\Formula\Optional\Formula_OptionalInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Donquixote\Ock\Summarizer\SummarizerInterface|null
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function create(
    Formula_OptionalInterface $formula,
    UniversalAdapterInterface $universalAdapter,
  ): ?SummarizerInterface {
    $decorated = $universalAdapter->adapt(
      $formula->getDecorated(),
      SummarizerInterface::class,
    );
    if ($decorated === NULL) {
      return NULL;
    }
    return new self($formula, $decorated);
  }

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Optional\Formula_OptionalInterface $formula
   * @param \Donquixote\Ock\Summarizer\SummarizerInterface $decorated
   */
  public function __construct(
    private readonly Formula_OptionalInterface $formula,
    private readonly SummarizerInterface $decorated,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): ?TextInterface {
    if (!\is_array($conf) || empty($conf['enabled'])) {
      return $this->formula->getEmptySummary();
    }
    return $this->decorated->confGetSummary($conf['options'] ?? NULL);
  }

}
