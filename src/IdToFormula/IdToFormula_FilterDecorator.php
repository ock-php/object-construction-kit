<?php

declare(strict_types=1);

namespace Ock\Ock\IdToFormula;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Id\Formula_IdInterface;

class IdToFormula_FilterDecorator implements IdToFormulaInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\IdToFormula\IdToFormulaInterface $decorated
   * @param \Ock\Ock\Formula\Id\Formula_IdInterface $condition
   *
   * @todo There should be a narrower interface for $condition parameter.
   */
  public function __construct(
    private readonly IdToFormulaInterface $decorated,
    private readonly Formula_IdInterface $condition,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function idGetFormula(string|int $id): ?FormulaInterface {
    if (!$this->condition->idIsKnown($id)) {
      return NULL;
    }
    return $this->decorated->idGetFormula($id);
  }

}
