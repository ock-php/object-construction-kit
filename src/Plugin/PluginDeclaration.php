<?php

declare(strict_types=1);

namespace Donquixote\Ock\Plugin;

use Donquixote\Ock\Core\Formula\FormulaInterface;

class PluginDeclaration {

  /**
   * Constructor.
   *
   * @param string $id
   *   Plugin id.
   * @param list<string> $types
   * @param \Donquixote\Ock\Plugin\Plugin $plugin
   *   The actual plugin object.
   */
  public function __construct(
    private readonly string $id,
    private array $types,
    private Plugin $plugin,
  ) {}

  /**
   * @return string
   */
  public function getId(): string {
    return $this->id;
  }

  /**
   * @param list<string> $types
   */
  public function withTypes(array $types): static {
    $clone = clone $this;
    $clone->types = $types;
    return $clone;
  }

  /**
   * @return list<string>
   */
  public function getTypes(): array {
    return $this->types;
  }

  /**
   * @return \Donquixote\Ock\Plugin\Plugin
   */
  public function getPlugin(): Plugin {
    return $this->plugin;
  }

  /**
   * @param \Donquixote\Ock\Plugin\Plugin $plugin
   *
   * @return static
   */
  public function withPlugin(Plugin $plugin): static {
    $clone = clone $this;
    $clone->plugin = $plugin;
    return $clone;
  }

  /**
   * @param string $key
   * @param mixed $value
   *
   * @return static
   */
  public function withSetting(string $key, mixed $value): static {
    $clone = clone $this;
    $clone->plugin = $this->plugin->withSetting($key, $value);
    return $clone;
  }

  /**
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $formula
   *
   * @return static
   */
  public function withFormula(FormulaInterface $formula): static {
    $clone = clone $this;
    $clone->plugin = $this->plugin->withFormula($formula);
    return $clone;
  }

}
