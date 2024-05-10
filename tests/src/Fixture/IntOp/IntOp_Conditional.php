<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests\Fixture\IntOp;

use Donquixote\Ock\Attribute\Parameter\OckOption;
use Donquixote\Ock\Attribute\Plugin\OckPluginInstance;
use Donquixote\Ock\Tests\Fixture\IntCondition\IntConditionInterface;

#[OckPluginInstance('conditional', 'Conditional')]
class IntOp_Conditional implements IntOpInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Tests\Fixture\IntCondition\IntConditionInterface $condition
   * @param \Donquixote\Ock\Tests\Fixture\IntOp\IntOpInterface|null $opIfTrue
   * @param \Donquixote\Ock\Tests\Fixture\IntOp\IntOpInterface|null $opIfFalse
   */
  public function __construct(
    #[OckOption('condition', 'Condition')]
    private readonly IntConditionInterface $condition,
    #[OckOption('opIfTrue', 'Op if true')]
    private readonly ?IntOpInterface $opIfTrue,
    #[OckOption('opIfFalse', 'Op if false')]
    private readonly ?IntOpInterface $opIfFalse,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function transform(int $number): int {
    $op = $this->condition->check($number)
      ? $this->opIfTrue
      : $this->opIfFalse;
    return ($op !== NULL)
      ? $op->transform($number)
      : $number;
  }

}
