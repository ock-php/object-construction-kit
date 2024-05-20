<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\SequenceVal;

use Ock\Ock\Formula\Sequence\Formula_SequenceInterface;
use Ock\Ock\V2V\Sequence\V2V_SequenceInterface;

class Formula_SequenceVal extends Formula_SequenceValBase {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Sequence\Formula_SequenceInterface $decorated
   * @param \Ock\Ock\V2V\Sequence\V2V_SequenceInterface $v2v
   */
  public function __construct(
    Formula_SequenceInterface $decorated,
    private readonly V2V_SequenceInterface $v2v,
  ) {
    parent::__construct($decorated);
  }

  /**
   * {@inheritdoc}
   */
  public function getV2V(): V2V_SequenceInterface {
    return $this->v2v;
  }

}
