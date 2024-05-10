<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Id;

use Donquixote\Ock\Core\Formula\FormulaInterface;

/**
 * Base interface for formulas where the value is id-like (string or integer).
 *
 * @todo Do we really need TextInterface here?
 */
interface Formula_IdInterface extends FormulaInterface {

  /**
   * Checks if an option exists for a given id.
   *
   * @param string|int $id
   *   The id.
   *
   * @return bool
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  public function idIsKnown(string|int $id): bool;

}
