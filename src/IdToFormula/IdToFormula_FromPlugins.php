<?php

declare(strict_types=1);

namespace Donquixote\Ock\IdToFormula;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Plugin\Plugin;

class IdToFormula_FromPlugins implements IdToFormulaInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Plugin\Plugin[] $plugins
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
