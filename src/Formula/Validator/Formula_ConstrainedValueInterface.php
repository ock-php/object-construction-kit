<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Validator;

use Donquixote\Ock\Core\Formula\FormulaInterface;

interface Formula_ConstrainedValueInterface extends FormulaInterface {

  /**
   * @param mixed $conf
   *
   * @return \Iterator<int, \Donquixote\Ock\Text\TextInterface>
   *   List of validation failures.
   */
  public function validate(mixed $conf): \Iterator;

}
