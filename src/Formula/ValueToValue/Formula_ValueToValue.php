<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\ValueToValue;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\V2V\Value\V2V_ValueInterface;

class Formula_ValueToValue extends Formula_ValueToValueBase {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $decorated
   * @param \Ock\Ock\V2V\Value\V2V_ValueInterface $v2v
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
