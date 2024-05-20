<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute;

/**
 * Annotates a method that returns an object construction formula.
 *
 * @see \Ock\Ock\Core\Formula\FormulaInterface
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class Formula {

  /**
   * Constructor.
   *
   * @param class-string $type
   *   The instance type produced by the plugin formula.
   *   Typically this should be an interface name.
   * @param string $id
   *   The id under which to register the plugin.
   * @param string $label
   *   Label for the plugin.
   * @param bool $translate
   *   TRUE to translate the label.
   */
  public function __construct(
    public readonly string $type,
    public readonly string $id,
    public readonly string $label,
    public readonly bool $translate = TRUE,
  ) {}

}
