<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\Parameter;

use Ock\Ock\Contract\FormulaHavingInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Neutral\Formula_Neutral_FormulaClass;

#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class OckFormulaFromClass implements FormulaHavingInterface {

  /**
   * Constructor.
   *
   * @param class-string<FormulaInterface> $formulaClass
   * @param mixed[] $args
   */
  public function __construct(
    private readonly string $formulaClass,
    private readonly array $args = [],
  ) {}

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface {
    return new Formula_Neutral_FormulaClass($this->formulaClass, $this->args);
  }

}
