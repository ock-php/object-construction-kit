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
   * @template T as object
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   * @param class-string<T> $interface
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return T|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  public static function getObject(
    FormulaInterface $formula,
    string $interface,
    UniversalAdapterInterface $universalAdapter,
  ): ?object {
    return $universalAdapter->adapt($formula, $interface);
  }

  /**
   * @template T of object
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   * @param class-string<T> $interface
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return T&object
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
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
