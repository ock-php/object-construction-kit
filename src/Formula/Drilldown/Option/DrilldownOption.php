<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Drilldown\Option;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Select\Option\SelectOption;
use Donquixote\Ock\Text\TextInterface;

class DrilldownOption extends SelectOption implements DrilldownOptionInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $formula
   * @param \Donquixote\Ock\Text\TextInterface|null $label
   * @param \Donquixote\Ock\Text\TextInterface|null $group_label
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
