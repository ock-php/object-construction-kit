<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Sequence;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Text\TextInterface;

interface Formula_SequenceInterface extends FormulaInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getItemFormula(): FormulaInterface;

  /**
   * Gets a label for the nth sequence item.
   *
   * @param int|null $delta
   *   Index of the sequence item, or NULL for the "new item" item.
   *
   * @return \Ock\Ock\Text\TextInterface
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function deltaGetItemLabel(?int $delta): TextInterface;

}
