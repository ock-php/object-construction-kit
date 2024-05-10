<?php

declare(strict_types=1);

namespace Donquixote\Ock\Summarizer;

use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Formula;
use Donquixote\Ock\FormulaAdapter;
use Donquixote\Ock\Util\UtilBase;

final class Summarizer extends UtilBase {

  /**
   * @param string $interface
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Donquixote\Ock\Summarizer\SummarizerInterface
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  public static function fromIface(
    string $interface,
    UniversalAdapterInterface $universalAdapter
  ): SummarizerInterface {
    return self::fromFormula(
      Formula::iface($interface),
      $universalAdapter);
  }

  /**
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Donquixote\Ock\Summarizer\SummarizerInterface
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   *   Cannot build a generator for the given formula.
   */
  public static function fromFormula(
    FormulaInterface $formula,
    UniversalAdapterInterface $universalAdapter
  ): SummarizerInterface {
    return FormulaAdapter::requireObject(
      $formula,
      SummarizerInterface::class,
      $universalAdapter,
    );
  }

}
