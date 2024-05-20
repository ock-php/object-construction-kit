<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\StringVal;

use Ock\Ock\Formula\Textfield\Formula_TextfieldInterface;
use Ock\Ock\V2V\String\V2V_StringInterface;

class Formula_StringVal extends Formula_StringValBase {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Textfield\Formula_TextfieldInterface $decorated
   * @param \Ock\Ock\V2V\String\V2V_StringInterface $v2v
   */
  public function __construct(
    Formula_TextfieldInterface $decorated,
    private readonly V2V_StringInterface $v2v,
  ) {
    parent::__construct($decorated);
  }

  /**
   * {@inheritdoc}
   */
  public function getV2V(): V2V_StringInterface {
    return $this->v2v;
  }

}
