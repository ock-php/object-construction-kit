<?php

declare(strict_types=1);

namespace Donquixote\Ock\Generator;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\Adaptism\Attribute\Parameter\UniversalAdapter;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Formula\DefaultConf\Formula_DefaultConfInterface;

/**
 * @see \Donquixote\Ock\Formula\DefaultConf\Formula_DefaultConfInterface
 */
class Generator_DefaultConf implements GeneratorInterface {

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
    #[Adaptee] Formula_DefaultConfInterface $formula,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter
  ): ?self {
    return new self(
      Generator::fromFormula(
        $formula->getDecorated(),
        $universalAdapter,
      ),
      $formula->getDefaultConf(),
    );
  }

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Generator\GeneratorInterface $decorated
   * @param mixed $defaultConf
   */
  public function __construct(
    private readonly GeneratorInterface $decorated,
    private readonly mixed $defaultConf,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {
    return $this->decorated->confGetPhp($conf ?? $this->defaultConf);
  }

}
