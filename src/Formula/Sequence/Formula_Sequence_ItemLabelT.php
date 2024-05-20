<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Sequence;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\Text_Replacements;
use Ock\Ock\Text\TextInterface;

class Formula_Sequence_ItemLabelT implements Formula_SequenceInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $itemFormula
   * @param \Ock\Ock\Text\TextInterface $newItemLabel
   * @param \Ock\Ock\Text\TextInterface $itemLabelN
   * @param string $placeholder
   */
  public function __construct(
    private readonly FormulaInterface $itemFormula,
    private readonly TextInterface $newItemLabel,
    private readonly TextInterface $itemLabelN,
    private readonly string $placeholder = '!n'
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
    return (NULL === $delta)
      ? $this->newItemLabel
      : new Text_Replacements($this->itemLabelN, [
        $this->placeholder => Text::i($delta + 1),
      ]);
  }

}
