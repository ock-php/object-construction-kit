<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Label;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\SkipEvaluator\Formula_ValuePassthruInterface;
use Donquixote\Ock\Text\TextInterface;

interface Formula_LabelInterface extends FormulaInterface, Formula_ValuePassthruInterface {

  /**
   * Gets the label.
   *
   * @return \Donquixote\Ock\Text\TextInterface|null
   *   The label as a text object, or NULL.
   */
  public function getLabel(): ?TextInterface;

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

}
