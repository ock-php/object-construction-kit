<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Group;

use Donquixote\Ock\Core\Formula\FormulaInterface;

interface Formula_GroupInterface extends FormulaInterface {

  /**
   * @return \Donquixote\Ock\Formula\Group\Item\GroupFormulaItemInterface[]
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  public function getItems(): array;

}
