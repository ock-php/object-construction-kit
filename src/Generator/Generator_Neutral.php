<?php

declare(strict_types=1);

namespace Donquixote\Ock\Generator;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\Adaptism\Attribute\Parameter\UniversalAdapter;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Formula\SkipEvaluator\Formula_ValuePassthruInterface;

class Generator_Neutral {

  /**
   * @param \Donquixote\Ock\Formula\SkipEvaluator\Formula_ValuePassthruInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Donquixote\Ock\Generator\GeneratorInterface|null
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function create(
    #[Adaptee] Formula_ValuePassthruInterface $formula,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
  ): ?GeneratorInterface {
    return Generator::fromFormula($formula->getDecorated(), $universalAdapter);
  }

}
