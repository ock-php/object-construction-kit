<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\ValueToValue;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Label\Formula_Label;
use Ock\Ock\FormulaBase\Decorator\Formula_DecoratorBase;
use Ock\Ock\Text\TextInterface;

abstract class Formula_ValueToValueBase extends Formula_DecoratorBase implements Formula_ValueToValueInterface {

  /**
   * @param \Ock\Ock\Text\TextInterface $label
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function withLabel(TextInterface $label): FormulaInterface {
    return new Formula_Label($this, $label);
  }

}
