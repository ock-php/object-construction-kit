<?php

declare(strict_types=1);

namespace Donquixote\Ock\Attribute\Parameter;

use Donquixote\Ock\Contract\FormulaHavingInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Neutral\Formula_Neutral_FormulaClass;

#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class OckFormulaFromClass implements FormulaHavingInterface {

  /**
   * Constructor.
   *
   * @param class-string<FormulaInterface> $formulaClass
   * @param array $args
   */
  public function __construct(
    private readonly string $formulaClass,
    private readonly array $args = [],
  ) {}

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface {
    return new Formula_Neutral_FormulaClass($this->formulaClass, $this->args);
  }

}
