<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\SelectOld;

use Ock\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface;
use Ock\Ock\IdToFormula\IdToFormulaInterface;

class Formula_Select_TwoStepFlatSelectComposite extends Formula_Select_TwoStepFlatSelectBase {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface $idFormula
   * @param \Ock\Ock\IdToFormula\IdToFormulaInterface<\Ock\Ock\Core\Formula\FormulaInterface> $idToSubFormula
   *   Ideally the sub-formulas should implement Formula_FlatSelectInterface.
   *   Otherwise they are ignored.
   */
  public function __construct(
    Formula_FlatSelectInterface $idFormula,
    private readonly IdToFormulaInterface $idToSubFormula
  ) {
    parent::__construct($idFormula);
  }

  /**
   * @param string $id
   *
   * @return \Ock\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface|null
   * @throws \Ock\Ock\Exception\FormulaException
   */
  protected function idGetSubFormula(string $id): ?Formula_FlatSelectInterface {
    $subFormula = $this->idToSubFormula->idGetFormula($id);
    if (!$subFormula instanceof Formula_FlatSelectInterface) {
      return NULL;
    }
    return $subFormula;
  }

}
