<?php

declare(strict_types=1);

namespace Donquixote\Ock\Optionlessness;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\FormulaBase\Formula_ConfPassthruInterface;
use Donquixote\Ock\Util\UtilBase;

final class Optionlessness_V2V extends UtilBase {

  /**
   * @param \Donquixote\Ock\Formula\ValueToValue\Formula_ValueToValueInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Donquixote\Ock\Optionlessness\OptionlessnessInterface|null
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function fromFormula(
    Formula_ConfPassthruInterface $formula,
    UniversalAdapterInterface $universalAdapter,
  ): ?OptionlessnessInterface {
    return $universalAdapter->adapt($formula->getDecorated(), OptionlessnessInterface::class);
  }

}
