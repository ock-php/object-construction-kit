<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Validator;

use Ock\Ock\Core\Formula\FormulaInterface;

interface Formula_ConstrainedValueInterface extends FormulaInterface {

  /**
   * @param mixed $conf
   *
   * @return \Iterator<int, \Ock\Ock\Text\TextInterface>
   *   List of validation failures.
   */
  public function validate(mixed $conf): \Iterator;

}
