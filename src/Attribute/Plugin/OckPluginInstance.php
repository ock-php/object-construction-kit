<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\Plugin;

/**
 * Marks a method or a class as producing a plugin instance.
 *
 * The target must be one of:
 * - An instantiable class.
 * - A public non-abstract static method with a return type that specifies a
 *   single class or interface name.
 *
 * At the moment, non-static methods are not supported.
 *
 * @see \Ock\Ock\Inspector\FactoryInspector_OckInstanceAttribute
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class OckPluginInstance {

  /**
   * Constructor.
   *
   * @param string $id
   *   Plugin id relative to the package.
   * @param string $label
   *   Label for the plugin.
   * @param bool $translate
   *   TRUE if the label should be translatable, FALSE if not.
   */
  public function __construct(
    public readonly string $id,
    public readonly string $label,
    public readonly bool $translate = TRUE,
  ) {}

}
