<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute;

/**
 * Annotates an OCK instance.
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class Instance {

  /**
   * Constructor.
   *
   * @param string $id
   *   The id under which to register the plugin.
   * @param string $label
   *   Label for the plugin.
   * @param bool $translate
   *   TRUE to translate the label.
   */
  public function __construct(
    public readonly string $id,
    public readonly string $label,
    public readonly bool $translate = TRUE,
  ) {}

}
