<?php

declare(strict_types=1);

namespace Ock\Ock\Plugin\GroupLabels;

class PluginGroupLabels implements PluginGroupLabelsInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Text\TextInterface[] $labels
   */
  public function __construct(
    private readonly array $labels,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getLabels(): array {
    return $this->labels;
  }

}
