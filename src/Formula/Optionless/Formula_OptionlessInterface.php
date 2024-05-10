<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Optionless;

use Donquixote\Ock\Core\Formula\FormulaInterface;

/**
 * Common base interface for all formulas that are not configurable.
 *
 * A formula class needs to implement one of the child interfaces to actually do
 * something.
 */
interface Formula_OptionlessInterface extends FormulaInterface {

}
