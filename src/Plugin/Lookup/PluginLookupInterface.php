<?php

declare(strict_types=1);

namespace Ock\Ock\Plugin\Lookup;

use Ock\Ock\Plugin\Plugin;

interface PluginLookupInterface {

  /**
   * Gets a specific plugin.
   *
   * @param string|int $id
   *
   * @return \Ock\Ock\Plugin\Plugin|null
   */
  public function getPlugin(string|int $id): ?Plugin;

}
