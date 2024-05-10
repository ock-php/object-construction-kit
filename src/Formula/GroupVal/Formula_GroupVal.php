<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\GroupVal;

use Donquixote\Ock\Formula\Group\Formula_Group_Empty;
use Donquixote\Ock\Formula\Group\Formula_GroupInterface;
use Donquixote\Ock\Formula\ValueProvider\Formula_FixedPhpInterface;
use Donquixote\Ock\V2V\Group\V2V_Group_EmptyWithValueProvider;
use Donquixote\Ock\V2V\Group\V2V_GroupInterface;

class Formula_GroupVal extends Formula_GroupValBase {

  /**
   * @param \Donquixote\Ock\Formula\ValueProvider\Formula_FixedPhpInterface $valueProvider
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
   * @param \Donquixote\Ock\Formula\Group\Formula_GroupInterface $decorated
   * @param \Donquixote\Ock\V2V\Group\V2V_GroupInterface $v2v
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
