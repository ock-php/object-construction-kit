<?php

declare(strict_types=1);

namespace Donquixote\Ock\Adapter;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\DID\Attribute\Parameter\GetService;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Exception\PluginListException;
use Donquixote\Ock\Formula\Drilldown\Formula_Drilldown;
use Donquixote\Ock\Formula\Iface\Formula_IfaceInterface;
use Donquixote\Ock\Formula\Select\Formula_Select_FromPlugins;
use Donquixote\Ock\IdToFormula\IdToFormula_FromPlugins;
use Donquixote\Ock\Plugin\Map\PluginMapInterface;

class SpecificAdapter_IfacePluginMap {

  /**
   * @throws \Donquixote\Adaptism\Exception\AdapterException
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
