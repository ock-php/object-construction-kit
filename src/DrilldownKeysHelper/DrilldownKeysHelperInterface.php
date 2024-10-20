<?php

declare(strict_types=1);

namespace Ock\Ock\DrilldownKeysHelper;

interface DrilldownKeysHelperInterface {

  /**
   * @param mixed $conf
   *
   * @return array{int|string|null, mixed}
   *   Format: [$id, $options]
   */
  public function unpack(mixed $conf): array;

  /**
   * @param string|int|null $id
   * @param mixed $options
   *
   * @return mixed[]|string|int|null
   */
  public function pack(string|int|null $id, mixed $options): array|string|int|null;

  /**
   * @return array{string|null, string|null}
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
