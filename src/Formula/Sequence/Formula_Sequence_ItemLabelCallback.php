<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Sequence;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Exception\FormulaException;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

class Formula_Sequence_ItemLabelCallback implements Formula_SequenceInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $itemFormula
   * @param callable(int|null): (TextInterface|string) $itemLabelCallback
   */
  public function __construct(
    private readonly FormulaInterface $itemFormula,
    private readonly mixed $itemLabelCallback,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getItemFormula(): FormulaInterface {
    return $this->itemFormula;
  }

  /**
   * {@inheritdoc}
   */
  public function deltaGetItemLabel(?int $delta): TextInterface {
    $label = ($this->itemLabelCallback)($delta);
    if ($label instanceof TextInterface) {
      return $label;
    }
    if (is_string($label)) {
      return Text::s($label);
    }
    if (is_int($label)) {
      return Text::i($label);
    }
    throw new FormulaException('Misbehaving item label callback.');
  }

}
