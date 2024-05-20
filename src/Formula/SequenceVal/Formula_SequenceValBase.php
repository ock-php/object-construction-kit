<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\SequenceVal;

use Ock\Ock\Formula\Sequence\Formula_SequenceInterface;
use Ock\Ock\FormulaBase\Decorator\Formula_DecoratorBase;

abstract class Formula_SequenceValBase extends Formula_DecoratorBase implements Formula_SequenceValInterface {

  /**
   * Same as parent, but requires a sequence formula.
   *
   * @param \Ock\Ock\Formula\Sequence\Formula_SequenceInterface $decorated
   */
  public function __construct(Formula_SequenceInterface $decorated) {
    parent::__construct($decorated);
  }

}
