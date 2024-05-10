<?php

declare(strict_types=1);

namespace Donquixote\Ock\Plugin\Map;

interface PluginMapInterface {

  /**
   * @return string[]
   *
   * @throws \Donquixote\Ock\Exception\PluginListException
   */
  public function getTypes(): array;

  /**
   * @param string $type
   *
   * @return \Donquixote\Ock\Plugin\Plugin[]
   *   Format: $[$type] = $plugins.
   *
   * @throws \Donquixote\Ock\Exception\PluginListException
   */
  public function typeGetPlugins(string $type): array;

}
