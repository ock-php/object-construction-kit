<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SelectOld;

use Donquixote\Ock\Plugin\Map\PluginMapInterface;
use Donquixote\Ock\Text\TextInterface;

class Formula_Select_FromPluginMap extends Formula_Select_BufferedBase {

  /**
   * @var \Donquixote\Ock\Plugin\Plugin[]|null
   */
  private ?array $plugins = null;

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Plugin\Map\PluginMapInterface $pluginMap
   * @param string $type
   */
  public function __construct(
    private readonly PluginMapInterface $pluginMap,
    private readonly string $type,
  ) {}

  /**
   * {@inheritdoc}
   */
  protected function initialize(array &$grouped_options, array &$group_labels): void {
    $plugins = $this->getPlugins();
    foreach ($plugins as $id => $plugin) {
      $label = $plugin->getLabel();
      // @todo Do something for the group label.
      $grouped_options[''][$id] = $label;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {
    $plugins = $this->getPlugins();
    if (!isset($plugins[$id])) {
      return NULL;
    }
    return $plugins[$id]->getLabel();
  }

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(string|int $id): bool {
    $plugins = $this->getPlugins();
    return isset($plugins[$id]);
  }

  /**
   * @return \Donquixote\Ock\Plugin\Plugin[]
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  private function getPlugins(): array {
    return $this->plugins
      ??= $this->pluginMap->typeGetPlugins($this->type);
  }

}
