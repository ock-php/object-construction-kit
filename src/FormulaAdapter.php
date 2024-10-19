<?php

declare(strict_types=1);

namespace Ock\Ock;

use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Formula;
use Ock\Ock\Util\UtilBase;

final class FormulaAdapter extends UtilBase {

  /**
   * Incarnates multiple formulas.
   *
   * @template T as object
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface[] $itemFormulas
   * @param class-string<T> $interface
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return T[]
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  public static function getMultiple(array $itemFormulas, string $interface, UniversalAdapterInterface $universalAdapter): array {

    Formula::validateMultiple($itemFormulas);

    $itemObjects = [];
    foreach ($itemFormulas as $k => $itemFormula) {
      $itemObjects[$k] = self::requireObject($itemFormula, $interface, $universalAdapter);
    }

    return $itemObjects;
  }

  /**
   * Adapts a formula, returning NULL if not possible.
   *
   * @template T as object
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   *   Formula to adapt.
   * @param class-string<T> $interface
   *   Expected result type.
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *   Adapter.
   *
   * @return object|null
   *   An instance of the result type.
   *
   * @phpstan-return T|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   *   No adapter can be found.
   *   This points to a misconfiguration.
   */
  public static function getObject(
    FormulaInterface $formula,
    string $interface,
    UniversalAdapterInterface $universalAdapter,
  ): ?object {
    return $universalAdapter->adapt($formula, $interface);
  }

  /**
   * Adapts a formula, or throws if not possible.
   *
   * @template T of object
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   *   Formula to adapt.
   * @param class-string<T> $interface
   *   Expected result type.
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *   Adapter.
   *
   * @return object
   *   An instance of the result type.
   *
   * @phpstan-return T&object
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   *   The formula cannot be adapted to the given result type.
   */
  public static function requireObject(
    FormulaInterface $formula,
    string $interface,
    UniversalAdapterInterface $universalAdapter,
  ): object {
    $object = $universalAdapter->adapt($formula, $interface);
    if ($object === null) {
      throw new AdapterException(\sprintf(
        'Failed to adapt %s to %s',
        MessageUtil::formatValue($formula),
        MessageUtil::formatValue($interface),
      ));
    }
    return $object;
  }

}
