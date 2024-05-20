<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Drilldown;

trait Formula_Drilldown_CustomKeysTrait {

  /**
   * @var string
   */
  private string $idKey = 'id';

  /**
   * @var string|null
   */
  private ?string $optionsKey = 'options';

  /**
   * @param string $idKey
   * @param string|null $optionsKey
   *
   * @return static
   */
  public function withKeys(string $idKey, ?string $optionsKey): static {
    $clone = clone $this;
    $clone->idKey = $idKey;
    $clone->optionsKey = $optionsKey;
    return $clone;
  }

  /**
   * {@inheritdoc}
   */
  public function getIdKey(): string {
    return $this->idKey;
  }

  /**
   * {@inheritdoc}
   */
  public function getOptionsKey(): ?string {
    return $this->optionsKey;
  }

}
