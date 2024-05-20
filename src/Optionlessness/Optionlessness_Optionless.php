<?php

declare(strict_types=1);

namespace Ock\Ock\Optionlessness;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Ock\Formula\Optionless\Formula_OptionlessInterface;
use Ock\Ock\Util\UtilBase;

/**
 * Adapter from Formula_Optionless* to Optionlessness*.
 */
final class Optionlessness_Optionless extends UtilBase {

  /**
   * @param \Ock\Ock\Formula\Optionless\Formula_OptionlessInterface $formula
   *
   * @return \Ock\Ock\Optionlessness\OptionlessnessInterface
   */
  #[Adapter]
  public static function fromFormula(
    Formula_OptionlessInterface $formula,
  ): OptionlessnessInterface {
    return new Optionlessness(TRUE);
  }

}
