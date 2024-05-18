<?php

declare(strict_types=1);

namespace Donquixote\Ock\Discovery\ParamToFormulaCTV;

use Ock\Egg\Egg\EggInterface;

interface ParamToFormulaCTVInterface {

  /**
   * @param \ReflectionParameter $parameter
   *
   * @return \Ock\Egg\Egg\EggInterface<\Donquixote\Ock\Core\Formula\FormulaInterface>|null
   */
  public function paramGetFormulaEgg(\ReflectionParameter $parameter): ?EggInterface;

}
