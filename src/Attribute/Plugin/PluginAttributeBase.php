<?php

/**
 * @file
 */

declare(strict_types=1);

namespace Donquixote\Ock\Attribute\Plugin;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Plugin\Plugin;
use Donquixote\Ock\Plugin\PluginDeclaration;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

abstract class PluginAttributeBase implements PluginAttributeInterface {

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

  /**
   * @return string
   */
  public function getId(): string {
    return $this->id;
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel(): TextInterface {
    return $this->translate
      ? Text::t($this->label)
      : Text::s($this->label);
  }

  /**
   * @param FormulaInterface $formula
   * @param list<string> $types
   *
   * @return PluginDeclaration
   */
  protected function formulaGetPluginDeclaration(FormulaInterface $formula, array $types): PluginDeclaration {
    $plugin = new Plugin($this->getLabel(), null, $formula, []);
    return new PluginDeclaration($this->id, $types, $plugin);
  }

}
