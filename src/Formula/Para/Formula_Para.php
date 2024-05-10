<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Para;

use Donquixote\Ock\Core\Formula\FormulaInterface;

class Formula_Para implements Formula_ParaInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $decorated
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $paraFormula
   */
  public function __construct(
    private readonly FormulaInterface $decorated,
    private readonly FormulaInterface $paraFormula,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getDecorated(): FormulaInterface {
    return $this->decorated;
  }

  /**
   * {@inheritdoc}
   */
  public function getParaFormula(): FormulaInterface {
    return $this->paraFormula;
  }

}
