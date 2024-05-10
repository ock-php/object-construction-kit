<?php

declare(strict_types=1);

namespace Donquixote\Ock\IdToFormula;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Id\Formula_IdInterface;

class IdToFormula_FilterDecorator implements IdToFormulaInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\IdToFormula\IdToFormulaInterface $decorated
   * @param \Donquixote\Ock\Formula\Id\Formula_IdInterface $condition
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
