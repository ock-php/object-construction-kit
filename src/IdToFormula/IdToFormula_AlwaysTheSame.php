<?php

declare(strict_types=1);

namespace Ock\Ock\IdToFormula;

use Ock\Ock\Core\Formula\FormulaInterface;

class IdToFormula_AlwaysTheSame implements IdToFormulaInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $sameFormula
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
