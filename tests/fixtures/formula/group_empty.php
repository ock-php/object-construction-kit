<?php

declare(strict_types=1);

use Ock\Ock\Formula\Formula;

// Group formula without any options.
return Formula::group()
  ->construct(stdClass::class);
