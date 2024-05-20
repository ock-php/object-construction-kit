<?php

declare(strict_types=1);

namespace Ock\Ock\Adapter;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\DID\Attribute\Parameter\GetService;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\FreeParameters\Formula_FreeParametersInterface;
use Ock\Egg\ParamToEgg\ParamToEggInterface;
use Psr\Container\ContainerInterface;

class SpecificAdapter_FreeParameters {

  /**
   * @param \Ock\Ock\Formula\FreeParameters\Formula_FreeParametersInterface $formula
   * @param \Psr\Container\ContainerInterface $container
   * @param \Ock\Egg\ParamToEgg\ParamToEggInterface $paramToEgg
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Ock\ClassDiscovery\Exception\DiscoveryException
   * @throws \Ock\DID\Exception\ContainerToValueException
   * @throws \ReflectionException
   */
  #[Adapter]
  public static function adapt(
    #[Adaptee] Formula_FreeParametersInterface $formula,
    #[GetService] ContainerInterface $container,
    #[GetService] ParamToEggInterface $paramToEgg,
  ): FormulaInterface {
    $args = [];
    foreach ($formula->getFreeParameters() as $index => $parameter) {
      $egg = $paramToEgg->paramGetEgg($parameter);
      if ($egg === NULL) {
        continue;
      }
      $args[$index] = $egg->hatch($container);
    }
    return $formula->withArgValues($args);
  }

}
