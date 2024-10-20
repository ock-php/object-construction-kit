<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Group\Item;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Text\TextInterface;

interface GroupFormulaItemInterface {

  /**
   * @return string[]
   *   Other keys in the group that this formula depends on.
   */
  public function dependsOnKeys(): array;

  /**
   * @param mixed[] $args
   *
   * @return \Ock\Ock\Text\TextInterface
   */
  public function getLabel(array $args = []): TextInterface;

  /**
   * @param mixed[] $args
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function getFormula(array $args = []): FormulaInterface;

}
