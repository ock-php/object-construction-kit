<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Select\Flat;

use Ock\Ock\Formula\IdToLabel\Formula_IdToLabelInterface;
use Ock\Ock\Text\TextInterface;

/**
 * @todo Maybe "Options" should be renamed to "Choice"?
 */
interface Formula_FlatSelectInterface extends Formula_IdToLabelInterface {

  /**
   * @return \Ock\Ock\Text\TextInterface[]
   *   Format: $[$optionKey] = $optionLabel
   */
  public function getOptions(): array;

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface;

}
