<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Formula;
use Ock\Ock\FormulaAdapter;
use Ock\Ock\Util\UtilBase;

final class Summarizer extends UtilBase {

  /**
   * @param string $interface
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Summarizer\SummarizerInterface
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
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
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Summarizer\SummarizerInterface
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
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
