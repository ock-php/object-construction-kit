<?php

declare(strict_types=1);

namespace Donquixote\Ock;

use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\CodegenTools\Util\MessageUtil;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Formula;
use Donquixote\Ock\Util\UtilBase;

final class FormulaAdapter extends UtilBase {

  /**
   * Incarnates multiple formulas.
   *
   * @template T as object
   *
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface[] $itemFormulas
   * @param class-string<T> $interface
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return T[]
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
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
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $formula
   * @param class-string<T> $interface
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return T|null
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  public static function getObject(
    FormulaInterface $formula,
    string $interface,
    UniversalAdapterInterface $universalAdapter,
  ): ?object {
    return $universalAdapter->adapt($formula, $interface);
  }

  /**
   * @template T as object
   *
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $formula
   * @param class-string<T> $interface
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return T
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
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
