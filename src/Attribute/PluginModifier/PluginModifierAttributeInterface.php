<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\PluginModifier;

use Ock\Ock\Plugin\PluginDeclaration;

interface PluginModifierAttributeInterface {

  /**
   * @param \Ock\Ock\Plugin\PluginDeclaration $declaration
   *
   * @return \Ock\Ock\Plugin\PluginDeclaration
   */
  public function modifyPlugin(PluginDeclaration $declaration): PluginDeclaration;

}
