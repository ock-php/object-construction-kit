<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Label;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\SkipEvaluator\Formula_ValuePassthruInterface;
use Ock\Ock\Text\TextInterface;

interface Formula_LabelInterface extends FormulaInterface, Formula_ValuePassthruInterface {

  /**
   * Gets the label.
   *
   * @return \Ock\Ock\Text\TextInterface|null
   *   The label as a text object, or NULL.
   */
  public function getLabel(): ?TextInterface;

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

}
