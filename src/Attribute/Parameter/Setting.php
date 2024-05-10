<?php

declare(strict_types=1);

namespace Donquixote\Ock\Attribute\Parameter;

use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

/**
 * Marks a configurable parameter.
 */
#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class Setting {

  public function __construct(
    private readonly string $name,
    private readonly string $label,
    private readonly bool $translate = true,
  ) {}

  /**
   * @return string
   */
  public function getName(): string {
    return $this->name;
  }

  /**
   * @return \Donquixote\Ock\Text\TextInterface
   */
  public function getLabel(): TextInterface {
    return $this->translate
      ? Text::t($this->label)
      : Text::s($this->label);
  }

}
