<?php

declare(strict_types=1);

namespace Donquixote\Ock\Discovery\ParamToFormulaCTV;

use Donquixote\DID\ContainerToValue\ContainerToValueInterface;

interface ParamToFormulaCTVInterface {

  /**
   * @param \ReflectionParameter $parameter
   *
   * @return \Donquixote\DID\ContainerToValue\ContainerToValueInterface<\Donquixote\Ock\Core\Formula\FormulaInterface>|null
   */
  public function paramGetFormulaCTV(\ReflectionParameter $parameter): ?ContainerToValueInterface;

}
