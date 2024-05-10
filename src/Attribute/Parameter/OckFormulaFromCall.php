<?php

declare(strict_types=1);

namespace Donquixote\Ock\Attribute\Parameter;

use Donquixote\Ock\Contract\FormulaHavingInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Neutral\Formula_Passthru_FormulaFactory;

#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class OckFormulaFromCall implements FormulaHavingInterface {

  /**
   * Constructor.
   *
   * @param callable(): FormulaInterface $formulaCallback
   * @param array $args
   */
  public function __construct(
    private readonly mixed $formulaCallback,
    private readonly array $args = [],
  ) {}

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface {
    return new Formula_Passthru_FormulaFactory($this->formulaCallback, $this->args);
  }

}
