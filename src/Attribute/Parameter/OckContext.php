<?php

declare(strict_types=1);

namespace Donquixote\Ock\Attribute\Parameter;

use Donquixote\Ock\Contract\FormulaHavingInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;

#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class OckContext implements FormulaHavingInterface {

  public function __construct(
    private readonly string $name,
  ) {}

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface {
    throw new \RuntimeException('Not implemented, ' . $this->name);
  }

}
