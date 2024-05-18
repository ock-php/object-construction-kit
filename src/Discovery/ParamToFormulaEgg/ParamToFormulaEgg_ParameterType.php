<?php

declare(strict_types=1);

namespace Donquixote\Ock\Discovery\ParamToFormulaEgg;

use Donquixote\ClassDiscovery\Util\ReflectionTypeUtil;
use Donquixote\Ock\Formula\Iface\Formula_Iface;
use Ock\Egg\Egg\Egg_Fixed;
use Ock\Egg\Egg\EggInterface;

class ParamToFormulaEgg_ParameterType implements ParamToFormulaEggInterface {

  /**
   * @inheritDoc
   *
   * @throws \Donquixote\ClassDiscovery\Exception\DiscoveryException
   */
  public function paramGetFormulaEgg(\ReflectionParameter $parameter): ?EggInterface {
    $class = ReflectionTypeUtil::getClassLikeType($parameter);
    if ($class === NULL) {
      return NULL;
    }
    return new Egg_Fixed(new Formula_Iface($class));
  }

}
