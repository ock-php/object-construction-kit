<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Attribute\Parameter\UniversalAdapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Formula\Optional\Formula_OptionalInterface;

class Generator_Optional implements GeneratorInterface {

  /**
   * @param \Ock\Ock\Formula\Optional\Formula_OptionalInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Generator\GeneratorInterface|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function create(
    #[Adaptee] Formula_OptionalInterface $formula,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
  ): ?GeneratorInterface {
    return new self(
      Generator::fromFormula(
        $formula->getDecorated(),
        $universalAdapter,
      ),
      $formula,
    );
  }

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Generator\GeneratorInterface $decorated
   * @param \Ock\Ock\Formula\Optional\Formula_OptionalInterface $formula
   */
  public function __construct(
    private readonly GeneratorInterface $decorated,
    private readonly Formula_OptionalInterface $formula,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {

    if (!\is_array($conf) || empty($conf['enabled'])) {
      return $this->formula->getEmptyPhp();
    }

    $subConf = $conf['options'] ?? NULL;

    return $this->decorated->confGetPhp($subConf);
  }

}
