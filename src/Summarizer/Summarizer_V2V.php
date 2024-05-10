<?php

declare(strict_types=1);

namespace Donquixote\Ock\Summarizer;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Donquixote\Ock\Util\UtilBase;

final class Summarizer_V2V extends UtilBase {

  /**
   * @param \Donquixote\Ock\FormulaBase\Formula_ConfPassthruInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Donquixote\Ock\Summarizer\SummarizerInterface|null
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function create(
    Formula_ConfPassthruInterface $formula,
    UniversalAdapterInterface $universalAdapter
  ): ?SummarizerInterface {
    return Summarizer::fromFormula(
      $formula->getDecorated(),
      $universalAdapter
    );
  }

}
