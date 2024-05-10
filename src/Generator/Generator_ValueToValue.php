<?php

declare(strict_types=1);

namespace Donquixote\Ock\Generator;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Formula\ValueToValue\Formula_ValueToValueInterface;
use Donquixote\Ock\V2V\Value\V2V_ValueInterface;

class Generator_ValueToValue implements GeneratorInterface {

  /**
   * @param \Donquixote\Ock\Formula\ValueToValue\Formula_ValueToValueInterface $valueToValueFormula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   *   No generator found for the decorated formula.
   */
  #[Adapter]
  public static function create(
    Formula_ValueToValueInterface $valueToValueFormula,
    UniversalAdapterInterface $universalAdapter,
  ): self {
    return new self(
      Generator::fromFormula(
        $valueToValueFormula->getDecorated(),
        $universalAdapter,
      ),
      $valueToValueFormula->getV2V(),
    );
  }

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Generator\GeneratorInterface $decorated
   * @param \Donquixote\Ock\V2V\Value\V2V_ValueInterface $v2v
   */
  public function __construct(
    private readonly GeneratorInterface $decorated,
    private readonly V2V_ValueInterface $v2v,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {
    $php = $this->decorated->confGetPhp($conf);
    return $this->v2v->phpGetPhp($php, $conf);
  }

}
