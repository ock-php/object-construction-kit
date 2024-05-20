<?php

declare(strict_types=1);

use Ock\Ock\Tests\Fixture\NumberFormat\NumberFormat_Native;
use Ock\Ock\Tests\Fixture\NumberFormat\NumberFormatInterface;

return static function (): NumberFormatInterface {
  return NumberFormat_Native::create(3, ',.');
};
