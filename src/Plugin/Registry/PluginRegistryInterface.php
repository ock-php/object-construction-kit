<?php

declare(strict_types=1);

namespace Ock\Ock\Plugin\Registry;

interface PluginRegistryInterface {

  /**
   * @return array<string, array<string, \Ock\Ock\Plugin\Plugin>>
   *   Format: $[$type][$id] = $plugin
   *
   * @throws \Ock\Ock\Exception\PluginListException
   *   A plugin is incorrectly defined.
   */
  public function getPluginsByType(): array;

}
