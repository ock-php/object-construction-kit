<?php

declare(strict_types=1);

namespace Donquixote\Ock\Adapter;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\Adaptism\Attribute\Parameter\UniversalAdapter;
use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\DID\Attribute\Parameter\GetService;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Exception\PluginListException;
use Donquixote\Ock\Formula\Drilldown\Formula_Drilldown;
use Donquixote\Ock\Formula\Iface\Formula_IfaceInterface;
use Donquixote\Ock\Formula\Select\Formula_Select_FromPlugins;
use Donquixote\Ock\Formula\Select\Formula_Select_InlineExpanded;
use Donquixote\Ock\IdToFormula\IdToFormula_FromPlugins;
use Donquixote\Ock\IdToFormula\IdToFormula_InlineExpanded;
use Donquixote\Ock\IdToFormula\IdToFormula_Replace;
use Donquixote\Ock\Plugin\GroupLabels\PluginGroupLabelsInterface;
use Donquixote\Ock\Plugin\Map\PluginMapInterface;

class SpecificAdapter_Iface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Plugin\Map\PluginMapInterface $pluginMap
   * @param \Donquixote\Ock\Plugin\GroupLabels\PluginGroupLabelsInterface $groupLabels
   */
  public function __construct(
    #[GetService] private readonly PluginMapInterface $pluginMap,
    #[GetService] private readonly PluginGroupLabelsInterface $groupLabels,
  ) {}

  /**
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public function adapt(
    #[Adaptee] Formula_IfaceInterface $formula,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
  ): ?FormulaInterface {
    try {
      return $this->typeGetFormula(
        $formula->getInterface(),
        $formula->allowsNull(),
        $universalAdapter,
      );
    }
    catch (PluginListException $e) {
      throw new AdapterException($e->getMessage(), 0, $e);
    }
  }

  /**
   * @param class-string $type
   * @param bool $or_null
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Donquixote\Ock\Exception\PluginListException
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  protected function typeGetFormula(
    string $type,
    bool $or_null,
    UniversalAdapterInterface $universalAdapter,
  ): FormulaInterface {
    $plugins = $this->pluginMap->typeGetPlugins($type);
    $inline_plugins = [];
    foreach ($plugins as $id => $plugin) {
      if ($plugin->is('inline')) {
        $inline_plugins[$id] = $plugin;
      }
    }

    // Regular plugins.
    $idFormula = new Formula_Select_FromPlugins(
      $plugins,
      $this->groupLabels->getLabels(),
    );
    $idToFormula = new IdToFormula_FromPlugins($plugins);

    $idToFormula = new IdToFormula_Replace(
      $idToFormula,
      $universalAdapter,
    );

    // Support "inline" plugins.
    $idFormula = new Formula_Select_InlineExpanded(
      $idFormula,
      new IdToFormula_FromPlugins($inline_plugins),
      $universalAdapter,
    );
    $idToFormula = new IdToFormula_InlineExpanded(
      $idToFormula,
      $universalAdapter,
    );

    // Build the drilldown formula.
    $drilldown = new Formula_Drilldown(
      $idFormula,
      $idToFormula,
      $or_null);

    // @todo Support decorators.
    return $drilldown;
  }

}
