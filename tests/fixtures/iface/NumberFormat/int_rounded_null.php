<?php

declare(strict_types=1);

use Donquixote\Ock\Tests\Fixture\NumberFormat\NumberFormat_IntRounded;
use Donquixote\Ock\Tests\Fixture\NumberFormat\NumberFormatInterface;

return static function (): NumberFormatInterface {
  return new NumberFormat_IntRounded(NULL);
};
