<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Formula\Optional\Formula_OptionalInterface;
use Ock\Ock\Text\TextInterface;

class Summarizer_Optional implements SummarizerInterface {

  /**
   * @param \Ock\Ock\Formula\Optional\Formula_OptionalInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Summarizer\SummarizerInterface|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
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
   * @param \Ock\Ock\Formula\Optional\Formula_OptionalInterface $formula
   * @param \Ock\Ock\Summarizer\SummarizerInterface $decorated
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
