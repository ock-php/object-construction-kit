<?php

declare(strict_types=1);

namespace Ock\Ock\IdToFormula;

use Ock\Ock\Core\Formula\FormulaInterface;

/**
 * @template T of FormulaInterface
 *
 * @template-implements \Ock\Ock\IdToFormula\IdToFormulaInterface<T>
 */
class IdToFormula_Callback implements IdToFormulaInterface {

  /**
   * @var callable(string|int): T
   */
  private mixed $callback;

  /**
   * Constructor.
   *
   * @param callable(string|int): T $callback
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
