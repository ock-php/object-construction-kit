<?php

declare(strict_types=1);

namespace Donquixote\Ock\Discovery\ParamToFormulaEgg;

use Ock\Egg\Egg\EggInterface;

interface ParamToFormulaEggInterface {

  /**
   * @param \ReflectionParameter $parameter
   *
   * @return \Ock\Egg\Egg\EggInterface<\Donquixote\Ock\Core\Formula\FormulaInterface>|null
   */
  public function paramGetFormulaEgg(\ReflectionParameter $parameter): ?EggInterface;

}
