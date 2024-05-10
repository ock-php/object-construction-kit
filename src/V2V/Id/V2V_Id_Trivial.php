<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\Id;

class V2V_Id_Trivial implements V2V_IdInterface {

  /**
   * {@inheritdoc}
   */
  public function idGetPhp(int|string $id): string {
    return var_export($id, TRUE);
  }

}
