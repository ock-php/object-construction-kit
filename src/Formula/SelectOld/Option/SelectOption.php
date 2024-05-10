<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SelectOld\Option;

use Donquixote\Ock\Text\TextInterface;

class SelectOption implements SelectOptionInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Text\TextInterface|null $label
   * @param \Donquixote\Ock\Text\TextInterface|null $groupLabel
   */
  public function __construct(
    private readonly ?TextInterface $label,
    private readonly ?TextInterface $groupLabel,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getLabel(): ?TextInterface {
    return $this->label;
  }

  /**
   * {@inheritdoc}
   */
  public function getGroupLabel(): ?TextInterface {
    return $this->groupLabel;
  }

}
