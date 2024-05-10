<?php

declare(strict_types=1);

namespace Donquixote\Ock\IdToFormula;

use Donquixote\Ock\Core\Formula\FormulaInterface;

class IdToFormula_Callback implements IdToFormulaInterface {

  /**
   * @var callable
   */
  private $callback;

  /**
   * Constructor.
   *
   * @param callable $callback
   */
  public function __construct(callable $callback) {
    $this->callback = $callback;
  }

  /**
   * {@inheritdoc}
   */
  public function idGetFormula(string|int $id): ?FormulaInterface {

    $candidate = \call_user_func($this->callback, $id);

    if (!$candidate instanceof FormulaInterface) {
      return NULL;
    }

    return $candidate;
  }

}
