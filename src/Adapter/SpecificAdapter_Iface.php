<?php

declare(strict_types=1);

namespace Ock\Ock\Adapter;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Attribute\Parameter\UniversalAdapter;
use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\DID\Attribute\Parameter\GetService;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Exception\PluginListException;
use Ock\Ock\Formula\Drilldown\Formula_Drilldown;
use Ock\Ock\Formula\Iface\Formula_IfaceInterface;
use Ock\Ock\Formula\Select\Formula_Select_FromPlugins;
use Ock\Ock\Formula\Select\Formula_Select_InlineExpanded;
use Ock\Ock\IdToFormula\IdToFormula_FromPlugins;
use Ock\Ock\IdToFormula\IdToFormula_InlineExpanded;
use Ock\Ock\IdToFormula\IdToFormula_Replace;
use Ock\Ock\Plugin\GroupLabels\PluginGroupLabelsInterface;
use Ock\Ock\Plugin\Map\PluginMapInterface;

class SpecificAdapter_Iface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Plugin\Map\PluginMapInterface $pluginMap
   * @param \Ock\Ock\Plugin\GroupLabels\PluginGroupLabelsInterface $groupLabels
   */
  public function __construct(
    #[GetService] private readonly PluginMapInterface $pluginMap,
    #[GetService] private readonly PluginGroupLabelsInterface $groupLabels,
  ) {}

  /**
   * @throws \Ock\Adaptism\Exception\AdapterException
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
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Ock\Ock\Exception\PluginListException
   * @throws \Ock\Ock\Exception\FormulaException
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
