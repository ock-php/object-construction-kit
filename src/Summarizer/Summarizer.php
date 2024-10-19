<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Formula;
use Ock\Ock\FormulaAdapter;
use Ock\Ock\Util\UtilBase;

/**
 * Shortcut methods to get SummarizerInterface objects.
 */
final class Summarizer extends UtilBase {

  /**
   * Gets a summarizer for an interface.
   *
   * @param class-string $interface
   *   Interface.
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *   The universal adapter.
   *
   * @return \Ock\Ock\Summarizer\SummarizerInterface
   *   Summarizer for the given interface.
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   *   Cannot build a summarizer for the given interface.
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
   *   Cannot build a summarizer for the given formula.
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
