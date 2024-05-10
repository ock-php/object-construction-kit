<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Sequence;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Text\TextInterface;

interface Formula_SequenceInterface extends FormulaInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getItemFormula(): FormulaInterface;

  /**
   * Gets a label for the nth sequence item.
   *
   * @param int|null $delta
   *   Index of the sequence item, or NULL for the "new item" item.
   *
   * @return \Donquixote\Ock\Text\TextInterface
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  public function deltaGetItemLabel(?int $delta): TextInterface;

}
