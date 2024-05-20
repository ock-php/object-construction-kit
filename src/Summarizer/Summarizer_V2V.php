<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Ock\Ock\Util\UtilBase;

final class Summarizer_V2V extends UtilBase {

  /**
   * @param \Ock\Ock\FormulaBase\Formula_ConfPassthruInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Summarizer\SummarizerInterface|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
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
