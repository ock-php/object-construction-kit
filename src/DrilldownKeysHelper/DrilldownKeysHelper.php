<?php

declare(strict_types=1);

namespace Ock\Ock\DrilldownKeysHelper;

use Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface;
use Ock\Ock\Util\UtilBase;

/**
 * Static methods related to DrilldownKeysHelperInterface.
 */
final class DrilldownKeysHelper extends UtilBase {

  /**
   * @param \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface $drilldown
   *
   * @return \Ock\Ock\DrilldownKeysHelper\DrilldownKeysHelperInterface
   */
  public static function fromFormula(Formula_DrilldownInterface $drilldown): DrilldownKeysHelperInterface {
    return self::fromKeys(
      $drilldown->getIdKey(),
      $drilldown->getOptionsKey());
  }

  /**
   * @param array-key|null $idKey
   * @param array-key|null $optionsKey
   *
   * @return \Ock\Ock\DrilldownKeysHelper\DrilldownKeysHelperInterface
   */
  public static function fromKeys(string|int|null $idKey, string|int|null $optionsKey): DrilldownKeysHelperInterface {

    if (NULL === $idKey) {
      return new DrilldownKeysHelper_IdKeyNull();
    }

    if (NULL === $optionsKey) {
      return new DrilldownKeysHelper_OptionsKeyNull($idKey);
    }

    return new DrilldownKeysHelper_Default($idKey, $optionsKey);
  }

}
