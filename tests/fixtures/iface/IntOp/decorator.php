<?php

declare(strict_types=1);

use Ock\Ock\Tests\Fixture\IntOp\IntOp_Add;
use Ock\Ock\Tests\Fixture\IntOp\IntOp_ExtraOpDecorator;
use Ock\Ock\Tests\Fixture\IntOp\IntOp_Multiply;
use Ock\Ock\Tests\Fixture\IntOp\IntOpInterface;

return static function (): IntOpInterface {
  return new IntOp_ExtraOpDecorator(
    new IntOp_ExtraOpDecorator(
      new IntOp_Multiply(5),
      new IntOp_Add(1),
    ),
    new IntOp_Add(2),
  );
};
