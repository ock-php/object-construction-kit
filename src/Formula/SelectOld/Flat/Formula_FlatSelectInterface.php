<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SelectOld\Flat;

use Donquixote\Ock\Formula\IdToLabel\Formula_IdToLabelInterface;
use Donquixote\Ock\Text\TextInterface;

/**
 * @todo Maybe "Options" should be renamed to "Choice"?
 */
interface Formula_FlatSelectInterface extends Formula_IdToLabelInterface {

  /**
   * @return \Donquixote\Ock\Text\TextInterface[]
   *   Format: $[$optionKey] = $optionLabel
   */
  public function getOptions(): array;

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface;

}
