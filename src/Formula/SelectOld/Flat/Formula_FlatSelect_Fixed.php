<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\SelectOld\Flat;

use Ock\Ock\Text\TextInterface;

class Formula_FlatSelect_Fixed implements Formula_FlatSelectInterface, FlatSelectBuilderInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Text\TextInterface[] $options
   */
  public function __construct(
    private array $options,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function add(string $name, TextInterface $label): FlatSelectBuilderInterface {
    $this->options[$name] = $label;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function create(): Formula_FlatSelectInterface {
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOptions(): array {
    return $this->options;
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {
    return $this->options[$id] ?? NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(string|int $id): bool {
    return isset($this->options[$id]);
  }

}
