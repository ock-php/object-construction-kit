<?php

declare(strict_types=1);

namespace Donquixote\Ock\Summarizer;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Formula\DefaultConf\Formula_DefaultConfInterface;
use Donquixote\Ock\Text\TextInterface;

class Summarizer_DefaultConf implements SummarizerInterface {

  /**
   * @param \Donquixote\Ock\Formula\DefaultConf\Formula_DefaultConfInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self|null
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
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
   * @param \Donquixote\Ock\Summarizer\SummarizerInterface $decorated
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
