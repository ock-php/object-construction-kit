<?php

declare(strict_types=1);

namespace Donquixote\Ock\Plugin\Map;

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;

#[AsDecorator(PluginMapInterface::class)]
class PluginMap_Buffer implements PluginMapInterface {

  /**
   * @var string[]|null
   */
  private ?array $types;

  /**
   * @var \Donquixote\Ock\Plugin\Plugin[][]
   */
  private array $pluginss = [];

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Plugin\Map\PluginMapInterface $decorated
   */
  public function __construct(
    #[AutowireDecorated]
    private readonly PluginMapInterface $decorated,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getTypes(): array {
    return $this->types
      ??= $this->decorated->getTypes();
  }

  /**
   * {@inheritdoc}
   */
  public function typeGetPlugins(string $type): array {
    return $this->pluginss[$type]
      ??= $this->decorated->typeGetPlugins($type);
  }

}
