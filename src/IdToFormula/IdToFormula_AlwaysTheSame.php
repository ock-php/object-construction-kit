<?php

declare(strict_types=1);

namespace Donquixote\Ock\IdToFormula;

use Donquixote\Ock\Core\Formula\FormulaInterface;

class IdToFormula_AlwaysTheSame implements IdToFormulaInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $sameFormula
   */
  public function __construct(
    private readonly FormulaInterface $sameFormula,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function idGetFormula(string|int $id): ?FormulaInterface {
    return $this->sameFormula;
  }

}
