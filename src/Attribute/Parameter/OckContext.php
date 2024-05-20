<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\Parameter;

use Ock\Ock\Contract\FormulaHavingInterface;
use Ock\Ock\Core\Formula\FormulaInterface;

#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class OckContext implements FormulaHavingInterface {

  public function __construct(
    private readonly string $name,
  ) {}

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface {
    throw new \RuntimeException('Not implemented, ' . $this->name);
  }

}
