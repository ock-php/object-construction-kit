<?php

declare(strict_types=1);

namespace Donquixote\Ock\InlineDrilldown;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Id\Formula_IdInterface;
use Donquixote\Ock\Formula\ValueToValue\Formula_ValueToValue;
use Donquixote\Ock\V2V\Value\V2V_ValueInterface;

class InlineDrilldown_V2V implements InlineDrilldownInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\InlineDrilldown\InlineDrilldownInterface $decorated
   * @param \Donquixote\Ock\V2V\Value\V2V_ValueInterface $v2v
   */
  public function __construct(
    private readonly InlineDrilldownInterface $decorated,
    private readonly V2V_ValueInterface $v2v,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getIdFormula(): Formula_IdInterface {
    return $this->decorated->getIdFormula();
  }

  /**
   * {@inheritdoc}
   */
  public function idGetFormula(string|int $id): ?FormulaInterface {
    $formula = $this->decorated->idGetFormula($id);
    if ($formula === NULL) {
      return NULL;
    }
    return new Formula_ValueToValue($formula, $this->v2v);
  }

}
