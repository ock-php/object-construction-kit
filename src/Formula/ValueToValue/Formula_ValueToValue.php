<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\ValueToValue;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\V2V\Value\V2V_ValueInterface;

class Formula_ValueToValue extends Formula_ValueToValueBase {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $decorated
   * @param \Donquixote\Ock\V2V\Value\V2V_ValueInterface $v2v
   */
  public function __construct(
    FormulaInterface $decorated,
    private readonly V2V_ValueInterface $v2v,
  ) {
    parent::__construct($decorated);
  }

  /**
   * {@inheritdoc}
   */
  public function getV2V(): V2V_ValueInterface {
    return $this->v2v;
  }

}
