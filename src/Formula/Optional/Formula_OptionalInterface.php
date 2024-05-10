<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Optional;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Text\TextInterface;

interface Formula_OptionalInterface extends FormulaInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   *   The non-optional version.
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return \Donquixote\Ock\Text\TextInterface|null
   */
  public function getEmptySummary(): ?TextInterface;

  /**
   * @return string
   *   Typically 'NULL'.
   *
   * @todo Does this need a helper?
   */
  public function getEmptyPhp(): string;

}
