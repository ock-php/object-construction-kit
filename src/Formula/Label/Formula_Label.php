<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Label;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\FormulaBase\Decorator\Formula_DecoratorBase;
use Donquixote\Ock\Text\TextInterface;

class Formula_Label extends Formula_DecoratorBase implements Formula_LabelInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $decorated
   * @param \Donquixote\Ock\Text\TextInterface|null $label
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
