<?php

declare(strict_types=1);

namespace Ock\Ock\Plugin;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Text\TextInterface;

class Plugin {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Text\TextInterface $label
   * @param \Ock\Ock\Text\TextInterface|null $description
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   * @param mixed[] $info
   */
  public function __construct(
    private readonly TextInterface $label,
    private readonly ?TextInterface $description,
    private FormulaInterface $formula,
    private array $info,
  ) {}

  /**
   * Helper method to validate an array of plugins.
   *
   * @param self ...$plugins
   */
  public static function validate(self ...$plugins): void {}

  /**
   * Gets a label for the plugin.
   *
   * @return \Ock\Ock\Text\TextInterface
   */
  public function getLabel(): TextInterface {
    return $this->label;
  }

  /**
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   *
   * @return static
   */
  public function withFormula(FormulaInterface $formula): static {
    $clone = clone $this;
    $clone->formula = $formula;
    return $clone;
  }

  /**
   * Gets a description for the plugin.
   *
   * @return \Ock\Ock\Text\TextInterface|null
   */
  public function getDescription(): ?TextInterface {
    return $this->description;
  }

  /**
   * Gets the formula for this plugin.
   *
   * The formula defines the available configuration options, and the way that
   * factory code shall be generated for the plugin.
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface {
    return $this->formula;
  }

  /**
   * Gets the (reduced) annotation data.
   *
   * @return mixed[]
   */
  public function getInfo(): array {
    return $this->info;
  }

  /**
   * Gets a boolean value from the annotation.
   *
   * @param string $key
   *
   * @return bool
   */
  public function is(string $key): bool {
    return !empty($this->info[$key]);
  }

  /**
   * Gets a value from the annotation.
   *
   * @param string $key
   *
   * @return mixed
   */
  public function get(string $key): mixed {
    return $this->info[$key];
  }

  /**
   * @param string $key
   * @param mixed $value
   *
   * @return static
   */
  public function withSetting(string $key, mixed $value): static {
    $clone = clone $this;
    $clone->info[$key] = $value;
    return $clone;
  }

}
