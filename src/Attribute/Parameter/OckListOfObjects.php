<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\Parameter;

use Ock\Ock\Contract\FormulaHavingInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Formula;
use Ock\Ock\Formula\Sequence\Formula_Sequence;
use Ock\Ock\Formula\Sequence\Formula_Sequence_ItemLabelT;
use Ock\Ock\Text\Text;

#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class OckListOfObjects implements FormulaHavingInterface {

  public function __construct(
    private readonly string $interface,
    private readonly ?string $singularLabel = null,
  ) {}

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface {
    $itemFormula = Formula::iface($this->interface);
    if ($this->singularLabel === null) {
      return new Formula_Sequence($itemFormula);
    }
    return new Formula_Sequence_ItemLabelT(
      $itemFormula,
      Text::t('New ' . $this->singularLabel),
      Text::t(\ucfirst($this->singularLabel) . ' #!n'),
      '!n',
    );
  }

}
