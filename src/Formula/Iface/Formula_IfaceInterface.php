<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Iface;

use Ock\Ock\Core\Formula\FormulaInterface;

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
