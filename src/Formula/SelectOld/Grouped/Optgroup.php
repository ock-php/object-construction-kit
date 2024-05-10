<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SelectOld\Grouped;

use Donquixote\Ock\Text\TextInterface;

class Optgroup {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Text\TextInterface|null $label
   *   The group label, or NULL for top-level options.
   * @param \Donquixote\Ock\Text\TextInterface[] $options
   *   Option labels within the group.
   *
   */
  public function __construct(
    private readonly ?TextInterface $label,
    private readonly array $options,
  ) {}

  /**
   * @return \Donquixote\Ock\Text\TextInterface|null
   *   Optgroup label, or NULL if this is for top-level options.
   */
  public function getLabel(): ?TextInterface {
    return $this->label;
  }

  /**
   * @return \Donquixote\Ock\Text\TextInterface[]
   */
  public function getOptions(): array {
    return $this->options;
  }

}
