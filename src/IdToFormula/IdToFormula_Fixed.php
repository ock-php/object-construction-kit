<?php

declare(strict_types=1);

namespace Ock\Ock\IdToFormula;

use Ock\Ock\Core\Formula\FormulaInterface;

/**
 * @template-implements IdToFormulaInterface<FormulaInterface>
 */
class IdToFormula_Fixed implements IdToFormulaInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface[] $formulas
   */
  public function __construct(
    private array $formulas,
  ) {}

  /**
   * @param string $id
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   *
   * @return \Ock\Ock\IdToFormula\IdToFormula_Fixed
   */
  public function withFormula(string $id, FormulaInterface $formula): IdToFormula_Fixed {
    $clone = clone $this;
    $clone->formulas[$id] = $formula;
    return $clone;
  }

  /**
   * {@inheritdoc}
   */
  public function idGetFormula(string|int $id): ?FormulaInterface {
    return $this->formulas[$id] ?? NULL;
  }

}
