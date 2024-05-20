<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Select\Grouped;

use Ock\Ock\Text\TextInterface;

class Optgroup {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Text\TextInterface|null $label
   *   The group label, or NULL for top-level options.
   * @param \Ock\Ock\Text\TextInterface[] $options
   *   Option labels within the group.
   *
   */
  public function __construct(
    private readonly ?TextInterface $label,
    private readonly array $options,
  ) {}

  /**
   * @return \Ock\Ock\Text\TextInterface|null
   *   Optgroup label, or NULL if this is for top-level options.
   */
  public function getLabel(): ?TextInterface {
    return $this->label;
  }

  /**
   * @return \Ock\Ock\Text\TextInterface[]
   */
  public function getOptions(): array {
    return $this->options;
  }

}
