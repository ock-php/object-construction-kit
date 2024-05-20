<?php

declare(strict_types=1);

namespace Ock\Ock\IdToFormula;

use Ock\Ock\Core\Formula\FormulaInterface;

class IdToFormula_Class implements IdToFormulaInterface {

  /**
   * Constructor.
   *
   * @param string $class
   */
  public function __construct(
    private readonly string $class,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function idGetFormula(string|int $id): ?FormulaInterface {

    $candidate = new ($this->class)($id);

    if (!$candidate instanceof FormulaInterface) {
      return NULL;
    }

    return $candidate;
  }

}
