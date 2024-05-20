<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\SelectOld;

use Ock\Ock\Formula\Id\Formula_IdInterface;
use Ock\Ock\FormulaBase\FormulaBase_AbstractSelectInterface;

/**
 * @todo Maybe "Options" should be renamed to "Choice"?
 *
 * @deprecated
 *
 * @see \Ock\Ock\Formula\Select\Formula_SelectInterface
 */
interface Formula_SelectInterface extends Formula_IdInterface, FormulaBase_AbstractSelectInterface {

}
