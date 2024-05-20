<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Boolean;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Text\TextInterface;

interface Formula_BooleanInterface extends FormulaInterface {

  /**
   * Gets a summary for true.
   *
   * @return \Ock\Ock\Text\TextInterface|null
   *   Summary in case the value is true.
   */
  public function getTrueSummary(): ?TextInterface;

  /**
   * @return \Ock\Ock\Text\TextInterface|null
   *   Summary in case the value is true.
   */
  public function getFalseSummary(): ?TextInterface;

}
