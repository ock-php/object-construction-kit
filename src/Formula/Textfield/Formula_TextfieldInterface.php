<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Textfield;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Text\TextInterface;

/**
 * @todo What about limited number of characters?
 */
interface Formula_TextfieldInterface extends FormulaInterface {

  /**
   * @return \Donquixote\Ock\Text\TextInterface|null
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
   * @return \Donquixote\Ock\Text\TextInterface[]
   */
  public function textGetValidationErrors(string $text): array;

}
