<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SelectOld;

use Donquixote\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface;
use Donquixote\Ock\Text\TextInterface;

class Formula_Select_FromFlatSelect implements Formula_SelectInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface $decorated
   */
  public function __construct(
    private readonly Formula_FlatSelectInterface $decorated,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getOptGroups(): array {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getOptions(?string $group_id): array {
    return $group_id === NULL
      ? $this->decorated->getOptions()
      : [];
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {
    return $this->decorated->idGetLabel($id);
  }

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(string|int $id): bool {
    return $this->decorated->idIsKnown($id);
  }

}
