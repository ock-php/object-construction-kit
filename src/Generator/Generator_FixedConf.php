<?php

declare(strict_types=1);

namespace Donquixote\Ock\Generator;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\Adaptism\Attribute\Parameter\UniversalAdapter;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Formula\FixedConf\Formula_FixedConfInterface;

class Generator_FixedConf implements GeneratorInterface {

  /**
   * @param \Donquixote\Ock\Formula\FixedConf\Formula_FixedConfInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Donquixote\Ock\Generator\GeneratorInterface
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function create(
    #[Adaptee] Formula_FixedConfInterface $formula,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
  ): GeneratorInterface {
    return new self(
      Generator::fromFormula($formula->getDecorated(), $universalAdapter),
      $formula->getConf());
  }

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Generator\GeneratorInterface $decorated
   * @param mixed $conf
   */
  public function __construct(
    private readonly GeneratorInterface $decorated,
    private readonly mixed $conf,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {
    return $this->decorated->confGetPhp($this->conf);
  }

}
