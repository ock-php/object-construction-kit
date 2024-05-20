<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Formula\ValueToValue\Formula_ValueToValueInterface;
use Ock\Ock\V2V\Value\V2V_ValueInterface;

class Generator_ValueToValue implements GeneratorInterface {

  /**
   * @param \Ock\Ock\Formula\ValueToValue\Formula_ValueToValueInterface $valueToValueFormula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
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
   * @param \Ock\Ock\Generator\GeneratorInterface $decorated
   * @param \Ock\Ock\V2V\Value\V2V_ValueInterface $v2v
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
