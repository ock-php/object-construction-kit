<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Group;

use Ock\Ock\Core\Formula\FormulaInterface;

interface Formula_GroupInterface extends FormulaInterface {

  /**
   * @return \Ock\Ock\Formula\Group\Item\GroupFormulaItemInterface[]
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function getItems(): array;

}
