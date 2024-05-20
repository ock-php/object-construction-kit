<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Formula\DefaultConf\Formula_DefaultConfInterface;
use Ock\Ock\Text\TextInterface;

class Summarizer_DefaultConf implements SummarizerInterface {

  /**
   * @param \Ock\Ock\Formula\DefaultConf\Formula_DefaultConfInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function create(
    Formula_DefaultConfInterface $formula,
    UniversalAdapterInterface $universalAdapter
  ): ?Summarizer_DefaultConf {
    $decorated = $universalAdapter->adapt(
      $formula->getDecorated(),
      SummarizerInterface::class,
    );
    if ($decorated === NULL) {
      return NULL;
    }
    return new self(
      $decorated,
      $formula->getDefaultConf(),
    );
  }

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Summarizer\SummarizerInterface $decorated
   * @param mixed $defaultConf
   */
  public function __construct(
    private readonly SummarizerInterface $decorated,
    private readonly mixed $defaultConf,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): ?TextInterface {
    return $this->decorated->confGetSummary($conf ?? $this->defaultConf);
  }

}
