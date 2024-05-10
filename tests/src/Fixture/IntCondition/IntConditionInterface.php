<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests\Fixture\IntCondition;

interface IntConditionInterface {

  /**
   * @param int $number
   *
   * @return bool
   */
  public function check(int $number): bool;

}
