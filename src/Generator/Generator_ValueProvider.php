<?php

declare(strict_types=1);

namespace Donquixote\Ock\Generator;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Ock\Formula\ValueProvider\Formula_FixedPhpInterface;

#[Adapter]
class Generator_ValueProvider implements GeneratorInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\ValueProvider\Formula_FixedPhpInterface $formula
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
