<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Iface;

use Donquixote\Ock\Core\Formula\FormulaInterface;

interface Formula_IfaceInterface extends FormulaInterface {

  /**
   * @return class-string
   */
  public function getInterface(): string;

  /**
   * @return bool
   */
  public function allowsNull(): bool;

}
