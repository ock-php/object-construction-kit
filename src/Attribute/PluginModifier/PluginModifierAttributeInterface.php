<?php

declare(strict_types=1);

namespace Donquixote\Ock\Attribute\PluginModifier;

use Donquixote\Ock\Plugin\PluginDeclaration;

interface PluginModifierAttributeInterface {

  /**
   * @param \Donquixote\Ock\Plugin\PluginDeclaration $declaration
   *
   * @return \Donquixote\Ock\Plugin\PluginDeclaration
   */
  public function modifyPlugin(PluginDeclaration $declaration): PluginDeclaration;

}
