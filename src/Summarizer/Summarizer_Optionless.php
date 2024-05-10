<?php

declare(strict_types=1);

namespace Donquixote\Ock\Summarizer;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Ock\Formula\Optionless\Formula_OptionlessInterface;
use Donquixote\Ock\Util\UtilBase;

final class Summarizer_Optionless extends UtilBase {

  /**
   * @param \Donquixote\Ock\Formula\Optionless\Formula_OptionlessInterface $formula
   *
   * @return \Donquixote\Ock\Summarizer\SummarizerInterface
   */
  #[Adapter]
  public static function create(
    /** @noinspection PhpUnusedParameterInspection */ Formula_OptionlessInterface $formula
  ): SummarizerInterface {
    return new Summarizer_Null();
  }

}
