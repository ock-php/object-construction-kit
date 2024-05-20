<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Textfield;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Text\TextInterface;

/**
 * @todo What about limited number of characters?
 */
interface Formula_TextfieldInterface extends FormulaInterface {

  /**
   * @return \Ock\Ock\Text\TextInterface|null
   */
  public function getDescription(): ?TextInterface;

  /**
   * @param string $text
   *
   * @return bool
   */
  public function textIsValid(string $text): bool;

  /**
   * @param string $text
   *
   * @return \Ock\Ock\Text\TextInterface[]
   */
  public function textGetValidationErrors(string $text): array;

}
