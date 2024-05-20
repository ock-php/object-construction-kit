<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\GroupVal;

use Ock\Ock\Formula\Group\Formula_Group_Empty;
use Ock\Ock\Formula\Group\Formula_GroupInterface;
use Ock\Ock\Formula\ValueProvider\Formula_FixedPhpInterface;
use Ock\Ock\V2V\Group\V2V_Group_EmptyWithValueProvider;
use Ock\Ock\V2V\Group\V2V_GroupInterface;

class Formula_GroupVal extends Formula_GroupValBase {

  /**
   * @param \Ock\Ock\Formula\ValueProvider\Formula_FixedPhpInterface $valueProvider
   *
   * @return self
   */
  public static function createEmpty(Formula_FixedPhpInterface $valueProvider): self {
    return new self(
      new Formula_Group_Empty(),
      new V2V_Group_EmptyWithValueProvider(
        $valueProvider));
  }

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
