<?php

declare(strict_types=1);

namespace Donquixote\Ock\Optionlessness;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Formula\Group\Formula_GroupInterface;
use Donquixote\Ock\Util\UtilBase;

/**
 * Adapter from Formula_Group* to Optionlessness*.
 */
final class Optionlessness_Group extends UtilBase {

  /**
   * @param \Donquixote\Ock\Formula\Group\Formula_GroupInterface $group
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Donquixote\Ock\Optionlessness\OptionlessnessInterface
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
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
