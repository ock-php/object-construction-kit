<?php

declare(strict_types=1);

use Ock\Ock\Exception\GeneratorException_IncompatibleConfiguration;

// Exception thrown in generator.
return static function () {
  throw new GeneratorException_IncompatibleConfiguration(
    'Value must be no greater than 100.',
  );
};
