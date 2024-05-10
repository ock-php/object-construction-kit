<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests\Fixture\IntOp;

interface IntOpInterface {

  /**
   * @param int $number
   *
   * @return int
   */
  public function transform(int $number): int;

}
