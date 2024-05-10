<?php

declare(strict_types=1);

namespace Donquixote\Ock\IdToFormula;

use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\InlineDrilldown\InlineDrilldown;

class IdToFormula_InlineExpanded implements IdToFormulaInterface {

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

    if (!str_contains((string) $id, '/')) {
      return $this->decorated->idGetFormula($id);
    }

    list($prefix, $suffix) = explode('/', (string) $id, 2);

    if (NULL === $rawNestedFormula = $this->decorated->idGetFormula($prefix)) {
      return NULL;
    }

    try {
      $subtree = InlineDrilldown::fromFormula(
        $rawNestedFormula,
        $this->universalAdapter);
    }
    catch (AdapterException) {
      // @todo Log this.
      return NULL;
    }

    $formula = $subtree->idGetFormula($suffix);

    return $formula;
  }

}
