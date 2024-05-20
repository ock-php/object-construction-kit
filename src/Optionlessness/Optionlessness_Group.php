<?php

declare(strict_types=1);

namespace Ock\Ock\Optionlessness;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Formula\Group\Formula_GroupInterface;
use Ock\Ock\Util\UtilBase;

/**
 * Adapter from Formula_Group* to Optionlessness*.
 */
final class Optionlessness_Group extends UtilBase {

  /**
   * @param \Ock\Ock\Formula\Group\Formula_GroupInterface $group
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Optionlessness\OptionlessnessInterface
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  #[Adapter]
  public static function fromFormula(
    Formula_GroupInterface $group,
    UniversalAdapterInterface $universalAdapter,
  ): OptionlessnessInterface {
    foreach ($group->getItems() as $item) {
      if ($item->dependsOnKeys()) {
        continue;
      }
      if (!Optionlessness::checkFormula($item->getFormula(), $universalAdapter)) {
        // At least one group item has config options.
        return new Optionlessness(FALSE);
      }
    }
    // None of the group items are configurable.
    return new Optionlessness(TRUE);
  }

}
