<?php

declare(strict_types=1);

namespace Ock\Ock\Optionlessness;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Ock\Ock\Util\UtilBase;

final class Optionlessness_V2V extends UtilBase {

  /**
   * @param \Ock\Ock\Formula\ValueToValue\Formula_ValueToValueInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Optionlessness\OptionlessnessInterface|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function fromFormula(
    Formula_ConfPassthruInterface $formula,
    UniversalAdapterInterface $universalAdapter,
  ): ?OptionlessnessInterface {
    return $universalAdapter->adapt($formula->getDecorated(), OptionlessnessInterface::class);
  }

}
