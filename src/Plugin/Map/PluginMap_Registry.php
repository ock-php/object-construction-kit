<?php

declare(strict_types=1);

namespace Donquixote\Ock\Plugin\Map;

use Donquixote\Ock\Plugin\Registry\PluginRegistryInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(public: true)]
class PluginMap_Registry implements PluginMapInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Plugin\Registry\PluginRegistryInterface $registry
   */
  public function __construct(
    private readonly PluginRegistryInterface $registry,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getTypes(): array {
    $pluginss = $this->registry->getPluginsByType();
    return array_keys($pluginss);
  }

  /**
   * {@inheritdoc}
   */
  public function typeGetPlugins(string $type): array {
    return $this->registry->getPluginsByType()[$type] ?? [];
  }

}
