<?php

declare(strict_types=1);

namespace Donquixote\Ock\Plugin\Registry;

interface PluginRegistryInterface {

  /**
   * @return array<string, array<string, \Donquixote\Ock\Plugin\Plugin>>
   *   Format: $[$type][$id] = $plugin
   *
   * @throws \Donquixote\Ock\Exception\PluginListException
   *   A plugin is incorrectly defined.
   */
  public function getPluginsByType(): array;

}
