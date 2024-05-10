<?php

declare(strict_types=1);

namespace Donquixote\Ock\Attribute\PluginModifier;

use Donquixote\Ock\Plugin\PluginDeclaration;

/**
 * Attribute to
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class OckPluginAdapter implements PluginModifierAttributeInterface {

  /**
   * {@inheritdoc}
   */
  public function modifyPlugin(PluginDeclaration $declaration): PluginDeclaration {
    // @todo Do something for adapters.
    return $declaration;
  }

}
