<?php

declare(strict_types=1);

namespace Donquixote\Ock\Plugin\Registry;

/**
 * Combines multiple registries.
 */
class PluginRegistry_Multiple implements PluginRegistryInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Plugin\Registry\PluginRegistryInterface[] $registries
   */
  public function __construct(
    private readonly array $registries,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getPluginsByType(): array {
    $pluginss = [];
    foreach ($this->registries as $registry) {
      foreach ($registry->getPluginsByType() as $type => $plugins) {
        foreach ($plugins as $id => $plugin) {
          $pluginss[$type][$id] = $plugin;
        }
      }
    }
    return $pluginss;
  }

}
