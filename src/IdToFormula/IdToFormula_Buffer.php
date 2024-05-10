<?php

declare(strict_types=1);

namespace Donquixote\Ock\IdToFormula;

use Donquixote\Ock\Core\Formula\FormulaInterface;

class IdToFormula_Buffer implements IdToFormulaInterface {

  /**
   * @var \Donquixote\Ock\Core\Formula\FormulaInterface[]
   */
  private array $buffer = [];

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\IdToFormula\IdToFormulaInterface $decorated
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
