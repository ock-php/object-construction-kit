<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SelectOld\Grouped;

use Donquixote\Ock\Formula\IdToLabel\Formula_IdToLabelInterface;

/**
 * @todo Maybe "Options" should be renamed to "Choice"?
 */
interface Formula_GroupedSelectInterface extends Formula_IdToLabelInterface {

  /**
   * @return Optgroup[]
   */
  public function getOptGroups(): array;

}
