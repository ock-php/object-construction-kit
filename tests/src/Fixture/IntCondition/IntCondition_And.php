<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Fixture\IntCondition;

use Ock\Ock\Attribute\Parameter\OckListOfObjects;
use Ock\Ock\Attribute\Parameter\OckOption;
use Ock\Ock\Attribute\Plugin\OckPluginInstance;

#[OckPluginInstance('and', 'Logical AND')]
class IntCondition_And implements IntConditionInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Tests\Fixture\IntCondition\IntConditionInterface[] $conditions
   */
  public function __construct(
    #[OckOption('conditions', 'Conditions')]
    #[OckListOfObjects(IntConditionInterface::class, 'condition')]
    private readonly array $conditions,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function check(int $number): bool {
    foreach ($this->conditions as $condition) {
      if (!$condition->check($number)) {
        return false;
      }
    }
    return true;
  }

}
