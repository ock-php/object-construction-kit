<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Select;

use Donquixote\Ock\Formula\IdToLabel\Formula_IdToLabelInterface;
use Donquixote\Ock\Text\TextInterface;

/**
 * @todo Maybe "Options" should be renamed to "Choice"?
 */
interface Formula_SelectInterface extends Formula_IdToLabelInterface {

  /**
   * @return array<string, string>
   *   Format: $[$id] = $groupId.
   *   Use empty string for the top-level group.
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  public function getOptionsMap(): array;

  /**
   * @param string|int $groupId
   *
   * @return \Donquixote\Ock\Text\TextInterface|null
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  public function groupIdGetLabel(string|int $groupId): ?TextInterface;

}
