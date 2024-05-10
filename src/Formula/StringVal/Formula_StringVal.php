<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\StringVal;

use Donquixote\Ock\Formula\Textfield\Formula_TextfieldInterface;
use Donquixote\Ock\V2V\String\V2V_StringInterface;

class Formula_StringVal extends Formula_StringValBase {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Textfield\Formula_TextfieldInterface $decorated
   * @param \Donquixote\Ock\V2V\String\V2V_StringInterface $v2v
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
