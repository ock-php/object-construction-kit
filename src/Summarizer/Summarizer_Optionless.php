<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Ock\Formula\Optionless\Formula_OptionlessInterface;
use Ock\Ock\Util\UtilBase;

final class Summarizer_Optionless extends UtilBase {

  /**
   * @param \Ock\Ock\Formula\Optionless\Formula_OptionlessInterface $formula
   *
   * @return \Ock\Ock\Summarizer\SummarizerInterface
   */
  #[Adapter]
  public static function create(
    /** @noinspection PhpUnusedParameterInspection */ Formula_OptionlessInterface $formula
  ): SummarizerInterface {
    return new Summarizer_Null();
  }

}
