<?php

declare(strict_types=1);

namespace Ock\Ock\FormulaBase;

use Ock\Ock\Text\TextInterface;

/**
 * This is a base interface, which by itself does NOT extend FormulaInterface.
 *
 * @todo Do we really need TextInterface here?
 */
interface FormulaBase_AbstractSelectInterface {

  /**
   * Gets named select optgroups.
   *
   * @return \Ock\Ock\Text\TextInterface[]
   *   Format: $[$group_id] = $group_label.
   *
   * @throws \Ock\Ock\Exception\FormulaException
   *   Failure to get options.
   */
  public function getOptGroups(): array;

  /**
   * Gets select options in a group.
   *
   * @param string|null $group_id
   *   Id of the optgroup, or NULL for top-level options.
   *
   * @return \Ock\Ock\Text\TextInterface[]
   *   Format: $[$value] = $label.
   *
   * @throws \Ock\Ock\Exception\FormulaException
   *   Failure to get options.
   */
  public function getOptions(?string $group_id): array;

  /**
   * @param string|int $id
   *
   * @return \Ock\Ock\Text\TextInterface|null
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function idGetLabel(string|int $id): ?TextInterface;

  /**
   * @param string|int $id
   *
   * @return bool
   *
   * @throws \Ock\Ock\Exception\FormulaException
   *
   * @see \Ock\Ock\Formula\Id\Formula_IdInterface::idIsKnown()
   */
  public function idIsKnown(string|int $id): bool;

}
