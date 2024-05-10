<?php

declare(strict_types=1);

namespace Donquixote\Ock\Exception;

/**
 * Duplicate key conflict when adding an item to a group formula.
 *
 * @see \Donquixote\Ock\Formula\Group\GroupFormulaBuilder::addItem()
 */
class GroupFormulaDuplicateKeyException extends FormulaException {

}
