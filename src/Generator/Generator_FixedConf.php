<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Attribute\Parameter\UniversalAdapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Formula\FixedConf\Formula_FixedConfInterface;

class Generator_FixedConf implements GeneratorInterface {

  /**
   * @param \Ock\Ock\Formula\FixedConf\Formula_FixedConfInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Generator\GeneratorInterface
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
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
   * @param \Ock\Ock\Generator\GeneratorInterface $decorated
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
