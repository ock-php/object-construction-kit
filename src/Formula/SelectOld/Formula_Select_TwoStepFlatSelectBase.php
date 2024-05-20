<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\SelectOld;

use Ock\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface;

abstract class Formula_Select_TwoStepFlatSelectBase extends Formula_Select_TwoStepFlatSelectGrandBase {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface $idFormula
   */
  public function __construct(
    private readonly Formula_FlatSelectInterface $idFormula,
  ) {}

  /**
   * @return \Ock\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface
   */
  protected function getIdFormula(): Formula_FlatSelectInterface {
    return $this->idFormula;
  }

}
