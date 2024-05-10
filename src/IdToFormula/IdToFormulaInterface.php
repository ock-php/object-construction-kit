<?php

declare(strict_types=1);

namespace Donquixote\Ock\IdToFormula;

use Donquixote\Ock\Core\Formula\FormulaInterface;

/**
 * @template T of \Donquixote\Ock\Core\Formula\FormulaInterface
 */
interface IdToFormulaInterface {

  /**
   * @param string|int $id
   *
   * @return T|null
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  public function idGetFormula(string|int $id): ?FormulaInterface;

}
