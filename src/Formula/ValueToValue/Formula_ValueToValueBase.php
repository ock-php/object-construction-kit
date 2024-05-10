<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\ValueToValue;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Label\Formula_Label;
use Donquixote\Ock\FormulaBase\Decorator\Formula_DecoratorBase;
use Donquixote\Ock\Text\TextInterface;

abstract class Formula_ValueToValueBase extends Formula_DecoratorBase implements Formula_ValueToValueInterface {

  /**
   * @param \Donquixote\Ock\Text\TextInterface $label
   *
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function withLabel(TextInterface $label): FormulaInterface {
    return new Formula_Label($this, $label);
  }

}
