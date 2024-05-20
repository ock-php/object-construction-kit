<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Transform;

class Formula_Transform_Rekey extends Formula_TransformBase {

  /**
   * @var string[]
   */
  private array $map = [];

  /**
   * @var string[]
   */
  private array $unmap = [];

  /**
   * @var string|null
   */
  private ?string $packedNullKey;

  /**
   * @var string|null
   */
  private ?string $unpackedNullKey;

  /**
   * @param string|null $packed_key
   * @param string|null $unpacked_key
   *
   * @return static
   */
  public function withKey(?string $packed_key, ?string $unpacked_key): static {
    $clone = clone $this;
    if ($packed_key === NULL) {
      if ($unpacked_key === NULL) {
        throw new \RuntimeException('Only one of the keys can be null.');
      }
      $this->unpackedNullKey = $unpacked_key;
    }
    elseif ($unpacked_key === NULL) {
      $this->packedNullKey = $packed_key;
    }
    else {
      $clone->map[$unpacked_key] = $packed_key;
      $clone->unmap[$packed_key] = $unpacked_key;
    }
    return $clone;
  }

  /**
   * {@inheritdoc}
   */
  public function unpack(mixed $packed_conf): mixed {
    if ($packed_conf === NULL) {
      $packed_conf = [];
    }
    elseif (!is_array($packed_conf)) {
      throw new \Exception('Packed configuration must be an array or NULL.');
    }
    $unpacked_conf = [];
    if ($this->packedNullKey !== NULL) {
      $unpacked_conf = $packed_conf[$this->packedNullKey] ?? [];
      unset($packed_conf[$this->packedNullKey]);
    }
    foreach (array_intersect_key($this->unmap, $packed_conf) as $packed_key => $unpacked_key) {
      $unpacked_conf[$unpacked_key] = $packed_conf[$packed_key];
      unset($packed_conf[$packed_key]);
    }
    if ($this->unpackedNullKey !== NULL) {
      $unpacked_conf[$this->unpackedNullKey] = $packed_conf;
    }
    return $unpacked_conf;
  }

  /**
   * {@inheritdoc}
   */
  public function pack(mixed $unpacked_conf): mixed {
    if ($unpacked_conf === NULL) {
      $unpacked_conf = [];
    }
    elseif (!is_array($unpacked_conf)) {
      throw new \Exception('Unpacked configuration must be an array or NULL.');
    }
    $packed_conf = [];
    if ($this->unpackedNullKey !== NULL) {
      $packed_conf = $unpacked_conf[$this->unpackedNullKey] ?? [];
      unset($unpacked_conf[$this->unpackedNullKey]);
    }
    foreach (array_intersect_key($this->map, $unpacked_conf) as $unpacked_key => $packed_key) {
      $packed_conf[$packed_key] = $unpacked_conf[$unpacked_key];
      unset($unpacked_conf[$unpacked_key]);
    }
    if ($this->packedNullKey !== NULL) {
      $packed_conf[$this->packedNullKey] = $unpacked_conf;
    }
    return $packed_conf;
  }

}
