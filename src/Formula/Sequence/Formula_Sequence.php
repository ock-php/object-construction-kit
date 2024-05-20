<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Sequence;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

class Formula_Sequence implements Formula_SequenceInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $itemFormula
   */
  public function __construct(
    private readonly FormulaInterface $itemFormula,
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
    return ($delta === NULL)
      ? Text::t('New item')
      : Text::i($delta + 1)
        ->wrapT('!n', 'Item #!n');
  }

  /**
   * @param \Ock\Ock\Text\TextInterface $newItemLabel
   * @param \Ock\Ock\Text\TextInterface $itemLabelN
   * @param string $placeholder
   *
   * @return \Ock\Ock\Formula\Sequence\Formula_Sequence_ItemLabelT
   */
  public function withItemLabels(
    TextInterface $newItemLabel,
    TextInterface $itemLabelN,
    string $placeholder = '!n'
  ): Formula_Sequence_ItemLabelT {
    return new Formula_Sequence_ItemLabelT(
      $this->itemFormula,
      $newItemLabel,
      $itemLabelN,
      $placeholder,
    );
  }

  /**
   * @param callable(int|null): (TextInterface|string) $itemLabelCallback
   *
   * @return \Ock\Ock\Formula\Sequence\Formula_Sequence_ItemLabelCallback
   */
  public function withItemLabelCallback(
    callable $itemLabelCallback,
  ): Formula_Sequence_ItemLabelCallback {
    return new Formula_Sequence_ItemLabelCallback(
      $this->itemFormula,
      $itemLabelCallback,
    );
  }

}
