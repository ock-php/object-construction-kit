<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\TwoStep;

interface V2V_TwoStepInterface {

  /**
   * @param string $firstItemPhp
   * @param string $secondItemPhp
   *
   * @return string
   */
  public function itemsPhpGetPhp(string $firstItemPhp, string $secondItemPhp): string;

}
