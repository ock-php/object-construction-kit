<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\PluginModifier;

use Ock\Ock\Plugin\PluginDeclaration;

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
