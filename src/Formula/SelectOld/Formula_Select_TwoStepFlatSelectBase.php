<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SelectOld;

use Donquixote\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface;

abstract class Formula_Select_TwoStepFlatSelectBase extends Formula_Select_TwoStepFlatSelectGrandBase {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface $idFormula
   */
  public function __construct(
    private readonly Formula_FlatSelectInterface $idFormula,
  ) {}

  /**
   * @return \Donquixote\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface
   */
  protected function getIdFormula(): Formula_FlatSelectInterface {
    return $this->idFormula;
  }

}
