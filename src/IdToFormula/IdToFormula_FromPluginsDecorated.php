<?php

declare(strict_types=1);

namespace Ock\Ock\IdToFormula;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Plugin\Plugin;

/**
 * @template-implements IdToFormulaInterface<FormulaInterface>
 */
class IdToFormula_FromPluginsDecorated implements IdToFormulaInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Plugin\Plugin[] $plugins
   */
  public function __construct(
    private readonly array $plugins,
  ) {
    Plugin::validate(...array_values($plugins));
  }

  /**
   * {@inheritdoc}
   */
  public function idGetFormula(string|int $id): ?FormulaInterface {

    if (!isset($this->plugins[$id])) {
      return NULL;
    }

    return $this->plugins[$id]->getFormula();
  }

}
