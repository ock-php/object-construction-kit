<?php

declare(strict_types=1);

namespace Ock\Ock\Exception;

/**
 * Duplicate key conflict when adding an item to a group formula.
 *
 * @see \Ock\Ock\Formula\Group\GroupFormulaBuilder::addItem()
 */
class GroupFormulaDuplicateKeyException extends FormulaException {

}
