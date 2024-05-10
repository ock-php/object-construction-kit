<?php

declare(strict_types=1);

use Donquixote\Ock\Formula\Formula;

// Group formula without any options.
return Formula::group()
  ->construct(stdClass::class);
