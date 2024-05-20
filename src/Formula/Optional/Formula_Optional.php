<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Optional;

use Ock\Ock\Text\TextInterface;

class Formula_Optional extends Formula_OptionalBase {

  /**
   * @var \Ock\Ock\Text\TextInterface|null
   */
  private ?TextInterface $emptySummary;

  /**
   * @var string
   */
  private string $emptyPhp = 'NULL';

  /**
   * @param \Ock\Ock\Text\TextInterface $emptySummary
   *
   * @return static
   */
  public function withEmptySummary(TextInterface $emptySummary): static {
    $clone = clone $this;
    $clone->emptySummary = $emptySummary;
    return $clone;
  }

  /**
   * @param string $emptyPhp
   *
   * @return static
   */
  public function withEmptyPhp(string $emptyPhp): static {
    $clone = clone $this;
    $clone->emptyPhp = $emptyPhp;
    return $clone;
  }

  /**
   * {@inheritdoc}
   */
  public function getEmptySummary(): ?TextInterface {
    return $this->emptySummary;
  }

  /**
   * {@inheritdoc}
   */
  public function getEmptyPhp(): string {
    return $this->emptyPhp;
  }

}
