<?php

declare(strict_types=1);

namespace Donquixote\Ock\Plugin\Lookup;

use Donquixote\Ock\Plugin\Plugin;

interface PluginLookupInterface {

  /**
   * Gets a specific plugin.
   *
   * @param string|int $id
   *
   * @return \Donquixote\Ock\Plugin\Plugin|null
   */
  public function getPlugin(string|int $id): ?Plugin;

}
