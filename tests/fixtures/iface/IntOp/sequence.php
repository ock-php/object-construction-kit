<?php

declare(strict_types=1);

use Ock\Ock\Tests\Fixture\IntOp\IntOp_Add;
use Ock\Ock\Tests\Fixture\IntOp\IntOp_Multiply;
use Ock\Ock\Tests\Fixture\IntOp\IntOp_Sequence;
use Ock\Ock\Tests\Fixture\IntOp\IntOpInterface;

return static function (): IntOpInterface {
  return new IntOp_Sequence([
    new IntOp_Add(5),
    new IntOp_Multiply(7),
  ]);
};
