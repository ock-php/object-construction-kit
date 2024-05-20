<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Optional;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Text\TextInterface;

interface Formula_OptionalInterface extends FormulaInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *   The non-optional version.
   */
  public function getDecorated(): FormulaInterface;

  /**
   * @return \Ock\Ock\Text\TextInterface|null
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
