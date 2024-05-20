<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Boolean;

class V2V_Boolean_Trivial implements V2V_BooleanInterface {

  /**
   * {@inheritdoc}
   */
  public function getTruePhp(): string {
    return 'TRUE';
  }

  /**
   * {@inheritdoc}
   */
  public function getFalsePhp(): string {
    return 'FALSE';
  }

}
