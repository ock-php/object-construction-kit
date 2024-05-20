<?php

declare(strict_types=1);

namespace Ock\Ock\Adapter;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Exception\AdapterException;
use Ock\DID\Attribute\Parameter\GetService;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Exception\PluginListException;
use Ock\Ock\Formula\Drilldown\Formula_Drilldown;
use Ock\Ock\Formula\Iface\Formula_IfaceInterface;
use Ock\Ock\Formula\Select\Formula_Select_FromPlugins;
use Ock\Ock\IdToFormula\IdToFormula_FromPlugins;
use Ock\Ock\Plugin\Map\PluginMapInterface;

class SpecificAdapter_IfacePluginMap {

  /**
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function formulaGetReplacement(
    #[Adaptee] Formula_IfaceInterface $formula,
    #[GetService] PluginMapInterface $pluginMap,
  ): ?FormulaInterface {
    try {
      $plugins = $pluginMap->typeGetPlugins($formula->getInterface());
    }
    catch (PluginListException $e) {
      throw new AdapterException($e->getMessage(), 0, $e);
    }
    $ff = new Formula_Drilldown(
      new Formula_Select_FromPlugins($plugins),
      new IdToFormula_FromPlugins($plugins),
      $formula->allowsNull());
    return $ff;
  }

}
