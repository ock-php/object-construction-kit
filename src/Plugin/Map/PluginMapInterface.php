<?php

declare(strict_types=1);

namespace Ock\Ock\Plugin\Map;

interface PluginMapInterface {

  /**
   * @return string[]
   *
   * @throws \Ock\Ock\Exception\PluginListException
   */
  public function getTypes(): array;

  /**
   * @param string $type
   *
   * @return \Ock\Ock\Plugin\Plugin[]
   *   Format: $[$type] = $plugins.
   *
   * @throws \Ock\Ock\Exception\PluginListException
   */
  public function typeGetPlugins(string $type): array;

}
