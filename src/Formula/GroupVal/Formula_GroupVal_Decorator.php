<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\GroupVal;

use Ock\Ock\Formula\Group\Formula_GroupInterface;
use Ock\Ock\V2V\Group\V2V_GroupInterface;

class Formula_GroupVal_Decorator extends Formula_GroupValBase {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Group\Formula_GroupInterface $decorated
   * @param \Ock\Ock\V2V\Group\V2V_GroupInterface $v2v
   */
  public function __construct(
    Formula_GroupInterface $decorated,
    private readonly V2V_GroupInterface $v2v,
  ) {
    parent::__construct($decorated);
  }

  /**
   * {@inheritdoc}
   */
  public function getV2V(): V2V_GroupInterface {
    return $this->v2v;
  }

}
