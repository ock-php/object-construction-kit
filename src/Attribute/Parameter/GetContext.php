<?php

declare(strict_types=1);

namespace Donquixote\Ock\Attribute\Parameter;

use Donquixote\DID\Attribute\Parameter\ServiceArgumentAttributeInterface;

/**
 * Marks a parameter to expect a service from the container.
 */
#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class GetContext implements ServiceArgumentAttributeInterface {

  public function getArgumentDefinition(\ReflectionParameter $parameter): mixed {
    // @todo Be smarter!
    return NULL;
  }

}
