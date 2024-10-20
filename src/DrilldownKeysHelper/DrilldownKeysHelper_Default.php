<?php

declare(strict_types=1);

namespace Ock\Ock\DrilldownKeysHelper;

class DrilldownKeysHelper_Default implements DrilldownKeysHelperInterface {

  /**
   * Constructor.
   *
   * @param string $idKey
   * @param string $optionsKey
   */
  public function __construct(
    private readonly string $idKey,
    private readonly string $optionsKey,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function unpack(mixed $conf): array {

    if (!\is_array($conf)) {
      return [NULL, NULL];
    }

    if (!isset($conf[$this->idKey])) {
      return [NULL, NULL];
    }

    if ('' === $id = $conf[$this->idKey]) {
      return [NULL, NULL];
    }

    if (!\is_string($id) && !\is_int($id)) {
      return [NULL, NULL];
    }

    if (!isset($conf[$this->optionsKey])) {
      return [$id, NULL];
    }

    return [$id, $conf[$this->optionsKey]];
  }

  /**
   * {@inheritdoc}
   *
   * @return mixed[]
   */
  public function pack($id, $options): array {

    if (NULL === $id) {
      $options = NULL;
    }

    return [
      $this->idKey => $id,
      $this->optionsKey => $options,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getKeys(): array {
    return [$this->idKey, $this->optionsKey];
  }

  /**
   * {@inheritdoc}
   */
  public function getIdKey(): ?string {
    return $this->idKey;
  }

  /**
   * {@inheritdoc}
   */
  public function getOptionsKey(): ?string {
    return $this->optionsKey;
  }

  /**
   * {@inheritdoc}
   */
  public function buildTrails(array $parentTrail): array {
    $idTrail = $optionsTrail = $parentTrail;
    $idTrail[] = $this->idKey;
    $optionsTrail[] = $this->optionsKey;
    return [$idTrail, $optionsTrail];
  }

}
