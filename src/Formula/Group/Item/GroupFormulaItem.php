<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Group\Item;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Text\TextInterface;

class GroupFormulaItem implements GroupFormulaItemInterface {

  public function __construct(
    private readonly TextInterface $label,
    private readonly FormulaInterface $formula,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function dependsOnKeys(): array {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel(array $args = []): TextInterface {
    return $this->label;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormula(array $args = []): FormulaInterface {
    return $this->formula;
  }

}
