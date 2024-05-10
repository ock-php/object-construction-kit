<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Select;

use Donquixote\Ock\Formula\Select\Flat\Formula_FlatSelectInterface;
use Donquixote\Ock\IdToFormula\IdToFormulaInterface;

class Formula_Select_TwoStepFlatSelectComposite extends Formula_Select_TwoStepFlatSelectGrandBase {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Select\Flat\Formula_FlatSelectInterface $idFormula
   * @param \Donquixote\Ock\IdToFormula\IdToFormulaInterface $idToSubFormula
   */
  public function __construct(
    private readonly Formula_FlatSelectInterface $idFormula,
    private readonly IdToFormulaInterface $idToSubFormula
  ) {}

  /**
   * @return \Donquixote\Ock\Formula\Select\Flat\Formula_FlatSelectInterface
   */
  protected function getIdFormula(): Formula_FlatSelectInterface {
    return $this->idFormula;
  }

  /**
   * @param string $id
   *
   * @return \Donquixote\Ock\Formula\Select\Flat\Formula_FlatSelectInterface|null
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  protected function idGetSubFormula(string $id): ?Formula_FlatSelectInterface {
    $subFormula = $this->idToSubFormula->idGetFormula($id);
    if (!$subFormula instanceof Formula_FlatSelectInterface) {
      return NULL;
    }
    return $subFormula;
  }

}
