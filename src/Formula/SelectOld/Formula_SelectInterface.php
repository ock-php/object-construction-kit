<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SelectOld;

use Donquixote\Ock\Formula\Id\Formula_IdInterface;
use Donquixote\Ock\FormulaBase\FormulaBase_AbstractSelectInterface;

/**
 * @todo Maybe "Options" should be renamed to "Choice"?
 *
 * @deprecated
 *
 * @see \Donquixote\Ock\Formula\Select\Formula_SelectInterface
 */
interface Formula_SelectInterface extends Formula_IdInterface, FormulaBase_AbstractSelectInterface {

}
