<?php

declare(strict_types=1);

use Donquixote\Ock\Tests\Fixture\NumberFormat\NumberFormat_Trivial;
use Donquixote\Ock\Tests\Fixture\NumberFormat\NumberFormatInterface;

return static function (): NumberFormatInterface {
  return new NumberFormat_Trivial();
};
