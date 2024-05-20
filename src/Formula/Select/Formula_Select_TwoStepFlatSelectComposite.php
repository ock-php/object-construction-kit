<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Select;

use Ock\Ock\Formula\Select\Flat\Formula_FlatSelectInterface;
use Ock\Ock\IdToFormula\IdToFormulaInterface;

class Formula_Select_TwoStepFlatSelectComposite extends Formula_Select_TwoStepFlatSelectGrandBase {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Select\Flat\Formula_FlatSelectInterface $idFormula
   * @param \Ock\Ock\IdToFormula\IdToFormulaInterface $idToSubFormula
   */
  public function __construct(
    private readonly Formula_FlatSelectInterface $idFormula,
    private readonly IdToFormulaInterface $idToSubFormula
  ) {}

  /**
   * @return \Ock\Ock\Formula\Select\Flat\Formula_FlatSelectInterface
   */
  protected function getIdFormula(): Formula_FlatSelectInterface {
    return $this->idFormula;
  }

  /**
   * @param string $id
   *
   * @return \Ock\Ock\Formula\Select\Flat\Formula_FlatSelectInterface|null
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
