<?php

declare(strict_types=1);

use Donquixote\Ock\Tests\Fixture\IntCondition\IntCondition_And;
use Donquixote\Ock\Tests\Fixture\IntCondition\IntCondition_GreaterThan;
use Donquixote\Ock\Tests\Fixture\IntCondition\IntCondition_Odd;
use Donquixote\Ock\Tests\Fixture\IntCondition\IntConditionInterface;

return static function (): IntConditionInterface {
  return new IntCondition_And([
    new IntCondition_Odd(),
    new IntCondition_GreaterThan(10),
  ]);
};
