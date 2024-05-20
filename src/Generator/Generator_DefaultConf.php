<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Attribute\Parameter\UniversalAdapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Formula\DefaultConf\Formula_DefaultConfInterface;

/**
 * @see \Ock\Ock\Formula\DefaultConf\Formula_DefaultConfInterface
 */
class Generator_DefaultConf implements GeneratorInterface {

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
   * @param \Ock\Ock\Generator\GeneratorInterface $decorated
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
