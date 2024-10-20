<?php

declare(strict_types=1);

namespace Ock\Ock\IdToFormula;

use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\InlineDrilldown\InlineDrilldown;

/**
 * @template-implements \Ock\Ock\IdToFormula\IdToFormulaInterface<FormulaInterface>
 */
class IdToFormula_InlineExpanded implements IdToFormulaInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\IdToFormula\IdToFormulaInterface<FormulaInterface> $decorated
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
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

    [$prefix, $suffix] = explode('/', (string) $id, 2);

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
