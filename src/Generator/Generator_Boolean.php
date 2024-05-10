<?php

declare(strict_types=1);

namespace Donquixote\Ock\Generator;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\Ock\Formula\Boolean\Formula_BooleanInterface;
use Donquixote\Ock\Formula\BoolVal\Formula_BoolValInterface;
use Donquixote\Ock\V2V\Boolean\V2V_Boolean_Trivial;
use Donquixote\Ock\V2V\Boolean\V2V_BooleanInterface;

class Generator_Boolean implements GeneratorInterface {

  #[Adapter]
  public static function createFromBooleanFormula(
    /** @noinspection PhpUnusedParameterInspection */
    #[Adaptee] Formula_BooleanInterface $formula,
  ): self {
    return new self(new V2V_Boolean_Trivial());
  }

  #[Adapter]
  public static function createFromBooleanValFormula(
    #[Adaptee] Formula_BoolValInterface $formula,
  ): self {
    return new self($formula->getV2V());
  }

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\V2V\Boolean\V2V_BooleanInterface $v2v
   */
  public function __construct(
    private readonly V2V_BooleanInterface $v2v,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {

    $boolean = !empty($conf);

    return $boolean
      ? $this->v2v->getTruePhp()
      : $this->v2v->getFalsePhp();
  }

}
