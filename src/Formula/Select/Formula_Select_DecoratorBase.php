<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Select;

use Ock\Ock\Text\TextInterface;

class Formula_Select_DecoratorBase implements Formula_SelectInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Select\Formula_SelectInterface $decorated
   */
  public function __construct(
    private readonly Formula_SelectInterface $decorated,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(int|string $id): bool {
    return $this->decorated->idIsKnown($id);
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(int|string $id): ?TextInterface {
    return $this->decorated->idGetLabel($id);
  }

  /**
   * {@inheritdoc}
   */
  public function getOptionsMap(): array {
    return $this->decorated->getOptionsMap();
  }

  /**
   * {@inheritdoc}
   */
  public function groupIdGetLabel(int|string $groupId): ?TextInterface {
    return $this->decorated->groupIdGetLabel($groupId);
  }

}
