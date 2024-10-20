<?php

declare(strict_types=1);

namespace Ock\Ock\Plugin\Registry;

use function Ock\Helpers\array_filter_instanceof;

/**
 * Combines multiple registries.
 */
class PluginRegistry_Multiple implements PluginRegistryInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Plugin\Registry\PluginRegistryInterface[] $registries
   */
  public function __construct(
    private readonly array $registries,
  ) {}

  /**
   * @param iterable<object> $objects
   *
   * @return self
   */
  public static function fromCandidateObjects(iterable $objects): self {
    $objects = \iterator_to_array($objects, false);
    $registries = array_filter_instanceof($objects, PluginRegistryInterface::class);
    return new self($registries);
  }

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
