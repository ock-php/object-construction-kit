<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute;

/**
 * Annotates a configurable parameter.
 */
#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class Option {

  /**
   * Constructor.
   *
   * @param string $name
   *   The name of the configurable parameter.
   * @param string $label
   *   Label for the plugin.
   * @param bool $translate
   *   TRUE to translate the label.
   */
  public function __construct(
    public readonly string $name,
    public readonly string $label,
    public readonly bool $translate = TRUE,
  ) {}

}
