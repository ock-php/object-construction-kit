<?php

declare(strict_types=1);

namespace Ock\Ock\IdToFormula;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Drilldown\Option\DrilldownOptionInterface;

/**
 * @template-implements IdToFormulaInterface<FormulaInterface>
 */
class IdToFormula_FromOptions implements IdToFormulaInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Drilldown\Option\DrilldownOptionInterface[] $options
   */
  public function __construct(
    private readonly array $options,
  ) {
    self::validateOptions(...array_values($options));
  }

  /**
   * @param \Ock\Ock\Formula\Drilldown\Option\DrilldownOptionInterface ...$options
   */
  private static function validateOptions(DrilldownOptionInterface ...$options): void {}

  /**
   * {@inheritdoc}
   */
  public function idGetFormula(string|int $id): ?FormulaInterface {

    if (!isset($this->options[$id])) {
      return NULL;
    }

    return $this->options[$id]->getFormula();
  }

}
