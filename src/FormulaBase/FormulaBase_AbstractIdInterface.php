<?php

declare(strict_types=1);

namespace Donquixote\Ock\FormulaBase;

interface FormulaBase_AbstractIdInterface {

  /**
   * @param string|int $id
   *
   * @return string|null
   */
  public function idGetLabel(string|int $id): ?string;

  /**
   * @param string|int $id
   *
   * @return bool
   */
  public function idIsKnown(string|int $id): bool;

}
