<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SequenceVal;

use Donquixote\Ock\Formula\Sequence\Formula_SequenceInterface;
use Donquixote\Ock\FormulaBase\Decorator\Formula_DecoratorBase;

abstract class Formula_SequenceValBase extends Formula_DecoratorBase implements Formula_SequenceValInterface {

  /**
   * Same as parent, but requires a sequence formula.
   *
   * @param \Donquixote\Ock\Formula\Sequence\Formula_SequenceInterface $decorated
   */
  public function __construct(Formula_SequenceInterface $decorated) {
    parent::__construct($decorated);
  }

}
