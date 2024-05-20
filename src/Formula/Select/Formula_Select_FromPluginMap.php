<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Select;

use Ock\Ock\Plugin\Map\PluginMapInterface;
use Ock\Ock\Text\TextInterface;

class Formula_Select_FromPluginMap implements Formula_SelectInterface {

  /**
   * @var \Ock\Ock\Plugin\Plugin[]|null
   */
  private ?array $plugins = null;

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Plugin\Map\PluginMapInterface $pluginMap
   * @param string $type
   */
  public function __construct(
    private readonly PluginMapInterface $pluginMap,
    private readonly string $type,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getOptionsMap(): array {
    // @todo Do something for the group label.
    return array_fill_keys(array_keys($this->getPlugins()), '');
  }

  /**
   * {@inheritdoc}
   */
  public function groupIdGetLabel(int|string $groupId): ?TextInterface {
    // @todo Do something for the group label.
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {
    return ($this->getPlugins()[$id] ?? NULL)?->getLabel();
  }

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(string|int $id): bool {
    return NULL !== ($this->getPlugins()[$id] ?? NULL);
  }

  /**
   * @return \Ock\Ock\Plugin\Plugin[]
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  private function getPlugins(): array {
    return $this->plugins
      ??= $this->pluginMap->typeGetPlugins($this->type);
  }

}
