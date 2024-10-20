<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\Parameter;

use Ock\Ock\Contract\FormulaHavingInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Neutral\Formula_Passthru_FormulaFactory;

#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class OckFormulaFromCall implements FormulaHavingInterface {

  /**
   * Constructor.
   *
   * @param callable(): FormulaInterface $formulaCallback
   * @param mixed[] $args
   */
  public function __construct(
    private readonly mixed $formulaCallback,
    private readonly array $args = [],
  ) {}

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface {
    return new Formula_Passthru_FormulaFactory($this->formulaCallback, $this->args);
  }

}
