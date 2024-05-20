<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Select\Option;

use Ock\Ock\Text\TextInterface;

class SelectOption implements SelectOptionInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Text\TextInterface|null $label
   * @param \Ock\Ock\Text\TextInterface|null $groupLabel
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
