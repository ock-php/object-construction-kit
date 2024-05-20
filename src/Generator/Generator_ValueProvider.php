<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Ock\Formula\ValueProvider\Formula_FixedPhpInterface;

#[Adapter]
class Generator_ValueProvider implements GeneratorInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\ValueProvider\Formula_FixedPhpInterface $formula
   */
  public function __construct(
    private readonly Formula_FixedPhpInterface $formula,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {
    return $this->formula->getPhp();
  }

}
