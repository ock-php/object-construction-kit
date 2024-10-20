<?php

declare(strict_types=1);

namespace Ock\Ock\IdToFormula;

use Ock\Ock\Core\Formula\FormulaInterface;

/**
 * @template-covariant T of \Ock\Ock\Core\Formula\FormulaInterface
 */
interface IdToFormulaInterface {

  /**
   * @param string|int $id
   *
   * @return T|null
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function idGetFormula(string|int $id): ?FormulaInterface;

}
