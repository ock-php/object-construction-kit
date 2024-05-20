<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Select;

use Ock\Ock\Formula\IdToLabel\Formula_IdToLabelInterface;
use Ock\Ock\Text\TextInterface;

/**
 * @todo Maybe "Options" should be renamed to "Choice"?
 */
interface Formula_SelectInterface extends Formula_IdToLabelInterface {

  /**
   * @return array<string, string>
   *   Format: $[$id] = $groupId.
   *   Use empty string for the top-level group.
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function getOptionsMap(): array;

  /**
   * @param string|int $groupId
   *
   * @return \Ock\Ock\Text\TextInterface|null
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function groupIdGetLabel(string|int $groupId): ?TextInterface;

}
