<?php

declare(strict_types=1);

namespace Donquixote\Ock\Optionlessness;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Ock\Formula\Optionless\Formula_OptionlessInterface;
use Donquixote\Ock\Util\UtilBase;

/**
 * Adapter from Formula_Optionless* to Optionlessness*.
 */
final class Optionlessness_Optionless extends UtilBase {

  /**
   * @param \Donquixote\Ock\Formula\Optionless\Formula_OptionlessInterface $formula
   *
   * @return \Donquixote\Ock\Optionlessness\OptionlessnessInterface
   */
  #[Adapter]
  public static function fromFormula(
    Formula_OptionlessInterface $formula,
  ): OptionlessnessInterface {
    return new Optionlessness(TRUE);
  }

}
