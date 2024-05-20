<?php

declare(strict_types=1);

namespace Ock\Ock\Util;

use Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface;

final class DrilldownUtil extends UtilBase {

  /**
   * @param \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface $formula
   * @param string $id
   * @param mixed $options
   *
   * @return array
   */
  public static function formulaBuildConf(Formula_DrilldownInterface $formula, string $id, mixed $options): array {

    return self::buildConf(
      $id,
      $options,
      $formula->getIdKey(),
      $formula->getOptionsKey());
  }

  /**
   * @param int|string|null $id
   * @param mixed $options
   * @param string $k0
   * @param string|null $k1
   *
   * @return array
   */
  public static function buildConf(int|string|null $id, mixed $options, string $k0 = 'id', ?string $k1 = 'options'): array {

    if (NULL === $k1) {
      $conf = \is_array($options)
        ? $options
        : [];
      $conf[$k0] = $id;
      return $conf;
    }

    if (NULL === $id) {
      $options = NULL;
    }

    return [
      $k0 => $id,
      $k1 => $options,
    ];
  }

  /**
   * @param \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface $formula
   * @param mixed $conf
   *
   * @return array
   */
  public static function drilldownConfGetIdOptions(Formula_DrilldownInterface $formula, mixed $conf): array {
    return self::confGetIdOptions(
      $conf,
      $formula->getIdKey(),
      $formula->getOptionsKey()
    );
  }

  /**
   * @param mixed $conf
   * @param string $k0
   * @param string|null $k1
   *
   * @return array
   *   Format: array($id, $options)
   */
  public static function confGetIdOptions(mixed $conf, string $k0 = 'id', ?string $k1 = 'options'): array {

    if (!\is_array($conf)) {
      return [NULL, NULL];
    }

    if (!isset($conf[$k0])) {
      return [NULL, NULL];
    }

    if ('' === $id = $conf[$k0]) {
      return [NULL, NULL];
    }

    if (!\is_string($id) && !\is_int($id)) {
      return [NULL, NULL];
    }

    if (NULL === $k1) {
      unset($conf[$k0]);
      return [$id, $conf];
    }

    if (!isset($conf[$k1])) {
      return [$id, NULL];
    }

    return [$id, $conf[$k1]];
  }

}
