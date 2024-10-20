<?php

declare(strict_types=1);

namespace Ock\Ock\IdToFormula;

use Ock\Ock\Core\Formula\FormulaInterface;

/**
 * @template T of \Ock\Ock\Core\Formula\FormulaInterface
 *
 * @template-implements \Ock\Ock\IdToFormula\IdToFormulaInterface<T>
 */
class IdToFormula_AlwaysTheSame implements IdToFormulaInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface&T $sameFormula
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
