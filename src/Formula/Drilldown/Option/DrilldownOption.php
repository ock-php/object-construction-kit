<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Drilldown\Option;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Select\Option\SelectOption;
use Ock\Ock\Text\TextInterface;

class DrilldownOption extends SelectOption implements DrilldownOptionInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   * @param \Ock\Ock\Text\TextInterface|null $label
   * @param \Ock\Ock\Text\TextInterface|null $group_label
   */
  public function __construct(
    private readonly FormulaInterface $formula,
    ?TextInterface $label,
    ?TextInterface $group_label,
  ) {
    parent::__construct($label, $group_label);
  }

  /**
   * {@inheritdoc}
   */
  public function getFormula(): FormulaInterface {
    return $this->formula;
  }

}
