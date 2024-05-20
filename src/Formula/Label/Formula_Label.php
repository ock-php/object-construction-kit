<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Label;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\FormulaBase\Decorator\Formula_DecoratorBase;
use Ock\Ock\Text\TextInterface;

class Formula_Label extends Formula_DecoratorBase implements Formula_LabelInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $decorated
   * @param \Ock\Ock\Text\TextInterface|null $label
   */
  public function __construct(
    FormulaInterface $decorated,
    private readonly ?TextInterface $label,
  ) {
    parent::__construct($decorated);
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel(): ?TextInterface {
    return $this->label;
  }

}
