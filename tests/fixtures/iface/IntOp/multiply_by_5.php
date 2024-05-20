<?php

declare(strict_types=1);

use Ock\Ock\Tests\Fixture\IntOp\IntOp_Multiply;
use Ock\Ock\Tests\Fixture\IntOp\IntOpInterface;

return static function (): IntOpInterface {
  return new IntOp_Multiply(5);
};
