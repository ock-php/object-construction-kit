<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\PluginModifier;

use Ock\Ock\Plugin\PluginDeclaration;

/**
 * Marks the annotated plugin as a decorator.
 *
 * This should be used in combination with another attribute to declare the
 * actual plugin.
 *
 * @see \Ock\Ock\Attribute\Plugin\PluginAttributeInterface
 *   Use one of these to declare the actual plugin.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class OckPluginDecorator implements PluginModifierAttributeInterface {

  /**
   * {@inheritdoc}
   */
  public function modifyPlugin(PluginDeclaration $declaration): PluginDeclaration {
    $types = [];
    foreach ($declaration->getTypes() as $type) {
      $types[] = "decorator<$type>";
    }
    return $declaration->withTypes($types);
  }

}
