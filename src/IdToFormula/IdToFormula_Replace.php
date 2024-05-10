<?php

declare(strict_types=1);

namespace Donquixote\Ock\IdToFormula;

use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Formula;

class IdToFormula_Replace implements IdToFormulaInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\IdToFormula\IdToFormulaInterface $decorated
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   */
  public function __construct(
    private readonly IdToFormulaInterface $decorated,
    private readonly UniversalAdapterInterface $universalAdapter,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function idGetFormula(string|int $id): ?FormulaInterface {
    $formula = $this->decorated->idGetFormula($id);
    if ($formula === NULL) {
      return NULL;
    }
    try {
      return Formula::replace($formula, $this->universalAdapter);
    }
    catch (AdapterException) {
      // @todo Log this.
      return NULL;
    }
  }

}
