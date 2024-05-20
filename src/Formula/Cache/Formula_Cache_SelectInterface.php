<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Cache;

interface Formula_Cache_SelectInterface extends Formula_CacheBaseInterface {

  /**
   * @return string[][]
   *   Format: $[$optgroupId][$id] = $label
   *   With $optgroupId = '' for toplevel options.
   */
  public function getGroupedOptions(): array;

  /**
   * @return string[]
   *   Format: $[$optgroupId] = $optgroupLabel
   */
  public function getOptgroupLabels(): array;

}
