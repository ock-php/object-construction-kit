<?php

declare(strict_types=1);

namespace Ock\Ock\Discovery\ParamToFormulaEgg;

use Ock\ClassDiscovery\Util\ReflectionTypeUtil;
use Ock\Ock\Formula\Iface\Formula_Iface;
use Ock\Egg\Egg\Egg_Fixed;
use Ock\Egg\Egg\EggInterface;

class ParamToFormulaEgg_ParameterType implements ParamToFormulaEggInterface {

  /**
   * @inheritDoc
   *
   * @throws \Ock\ClassDiscovery\Exception\DiscoveryException
   */
  public function paramGetFormulaEgg(\ReflectionParameter $parameter): ?EggInterface {
    $class = ReflectionTypeUtil::getClassLikeType($parameter);
    if ($class === NULL) {
      return NULL;
    }
    return new Egg_Fixed(new Formula_Iface($class));
  }

}
