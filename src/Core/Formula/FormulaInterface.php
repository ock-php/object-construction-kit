<?php

declare(strict_types=1);

namespace Ock\Ock\Core\Formula;

use Ock\Ock\Core\Formula\Base\FormulaBaseInterface;

/**
 * This is a declarative interface only. It has no methods.
 *
 * A formula defines available configuration options for a plugin, and how an
 * object or value can be generated from a given configuration value.
 *
 * The actual behavior for each formula type has to be implemented in adapter
 * classes.
 *
 * This architecture allows to add new behavior to a formula type, without
 * adding new methods to the formula interface.
 */
interface FormulaInterface extends FormulaBaseInterface {

}
