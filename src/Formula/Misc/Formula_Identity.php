<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Misc;

use Donquixote\CodegenTools\Util\CodeGen;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Donquixote\Ock\Generator\GeneratorInterface;
use Donquixote\Ock\Summarizer\SummarizerInterface;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

final class Formula_Identity implements FormulaInterface, GeneratorInterface, SummarizerInterface {

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {
    try {
      return CodeGen::phpValue($conf);
    }
    catch (\Exception $e) {
      throw new GeneratorException_IncompatibleConfiguration($e->getMessage(), 0, $e);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): ?TextInterface {
    return Text::s(var_export($conf, TRUE));
  }

}
