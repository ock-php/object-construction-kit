<?php

declare(strict_types=1);

namespace Donquixote\Ock\Discovery\ParamToFormulaCTV;

use Donquixote\DID\ContainerToValue\ContainerToValue_Fixed;
use Donquixote\DID\ContainerToValue\ContainerToValueInterface;
use Donquixote\ClassDiscovery\Util\ReflectionTypeUtil;
use Donquixote\Ock\Formula\Iface\Formula_Iface;

class ParamToFormulaCTV_ParameterType implements ParamToFormulaCTVInterface {

  /**
   * @inheritDoc
   *
   * @throws \Donquixote\ClassDiscovery\Exception\DiscoveryException
   */
  public function paramGetFormulaCTV(\ReflectionParameter $parameter): ?ContainerToValueInterface {
    $class = ReflectionTypeUtil::getClassLikeType($parameter);
    if ($class === NULL) {
      return NULL;
    }
    return new ContainerToValue_Fixed(new Formula_Iface($class));
  }

}
