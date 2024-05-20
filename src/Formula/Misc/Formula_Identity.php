<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Misc;

use Ock\CodegenTools\Util\CodeGen;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Ock\Ock\Generator\GeneratorInterface;
use Ock\Ock\Summarizer\SummarizerInterface;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

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
