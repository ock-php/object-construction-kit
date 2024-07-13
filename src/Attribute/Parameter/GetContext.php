<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\Parameter;

/**
 * Marks a parameter to expect a context that narrows the formula.
 *
 * @todo Further design the context feature.
 */
#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class GetContext {

}
