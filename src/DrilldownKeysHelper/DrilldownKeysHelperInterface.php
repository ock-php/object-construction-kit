<?php

declare(strict_types=1);

namespace Ock\Ock\DrilldownKeysHelper;

interface DrilldownKeysHelperInterface {

  /**
   * @param mixed $conf
   *
   * @return array
   *   Format: [$id, $options]
   */
  public function unpack(mixed $conf): array;

  /**
   * @param string|int $id
   * @param mixed $options
   *
   * @return array|string|int
   */
  public function pack(string|int $id, mixed $options): array|string|int;

  /**
   * @return array
   *   Format: [$idKey, $optionsKey]
   */
  public function getKeys(): array;

  /**
   * @return string|null
   */
  public function getIdKey(): ?string;

  /**
   * @return string|null
   */
  public function getOptionsKey(): ?string;

  /**
   * @param string[] $parentTrail
   *
   * @return string[][]
   *   Format: [$idTrail, $optionsTrail]
   */
  public function buildTrails(array $parentTrail): array;

}
