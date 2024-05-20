<?php

declare(strict_types=1);

namespace Ock\Ock\IdToFormula;

use Ock\Ock\Core\Formula\FormulaInterface;

class IdToFormula_Buffer implements IdToFormulaInterface {

  /**
   * @var \Ock\Ock\Core\Formula\FormulaInterface[]
   */
  private array $buffer = [];

  /**
   * Constructor.
   *
   * @param \Ock\Ock\IdToFormula\IdToFormulaInterface $decorated
   */
  public function __construct(
    private readonly IdToFormulaInterface $decorated,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function idGetFormula(string|int $id): ?FormulaInterface {
    // @todo Optimize with isset()? But allow NULL values?
    return array_key_exists($id, $this->buffer)
      ? $this->buffer[$id]
      : $this->buffer[$id] = $this->decorated->idGetFormula($id);
  }

}
