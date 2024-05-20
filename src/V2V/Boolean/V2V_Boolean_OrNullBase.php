<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Boolean;

abstract class V2V_Boolean_OrNullBase implements V2V_BooleanInterface {

  /**
   * {@inheritdoc}
   */
  public function getFalsePhp(): string {
    return 'NULL';
  }

}
