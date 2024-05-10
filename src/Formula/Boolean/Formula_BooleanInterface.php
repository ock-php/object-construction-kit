<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Boolean;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Text\TextInterface;

interface Formula_BooleanInterface extends FormulaInterface {

  /**
   * Gets a summary for true.
   *
   * @return \Donquixote\Ock\Text\TextInterface|null
   *   Summary in case the value is true.
   */
  public function getTrueSummary(): ?TextInterface;

  /**
   * @return \Donquixote\Ock\Text\TextInterface|null
   *   Summary in case the value is true.
   */
  public function getFalseSummary(): ?TextInterface;

}
