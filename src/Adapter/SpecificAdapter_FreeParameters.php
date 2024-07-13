<?php

declare(strict_types=1);

namespace Ock\Ock\Adapter;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Attribute\Parameter\AdapterTargetType;
use Ock\Adaptism\Attribute\Parameter\UniversalAdapter;
use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Egg\Exception\ToEggException;
use Ock\Egg\ParamToEgg\ParamToEggInterface;
use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\FreeParameters\Formula_FreeParametersInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

class SpecificAdapter_FreeParameters {

  /**
   * @template T of object
   *
   * @param \Ock\Ock\Formula\FreeParameters\Formula_FreeParametersInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   * @param class-string<T> $targetType
   * @param \Psr\Container\ContainerInterface $container
   * @param \Ock\Egg\ParamToEgg\ParamToEggInterface $paramToEgg
   *
   * @return object|null
   *
   * @phpstan-return T|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function bridge(
    #[Adaptee] Formula_FreeParametersInterface $formula,
    #[AdapterTargetType] string $targetType,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
    ContainerInterface $container,
    ParamToEggInterface $paramToEgg,
  ): ?object {
    $resultFormula = static::adapt(
      $formula,
      $container,
      $paramToEgg,
    );
    if ($resultFormula === NULL) {
      return NULL;
    }
    return $universalAdapter->adapt($resultFormula, $targetType);
  }

  /**
   * Final adapter that will be called if other adapters have failed.
   *
   * @param \Ock\Ock\Formula\FreeParameters\Formula_FreeParametersInterface $formula
   *   The formula that failed with other adapters.
   * @param class-string $targetType
   *   Target type.
   *
   * @return object
   *   This would be the adapted object, but in fact, this method always fails.
   *   The return type still needs to be 'object' for the discovery to work.
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  #[Adapter(999)]
  public static function giveUp(
    #[Adaptee] Formula_FreeParametersInterface $formula,
    #[AdapterTargetType] string $targetType,
  ): object {
    $parameters = $formula->getFreeParameters();
    if (!$parameters) {
      throw new AdapterException(sprintf(
        'No free parameters left, but still failed to adapt to %s.',
        $targetType,
      ));
    }
    throw new AdapterException(sprintf(
      'Cannot resolve free %s.',
      MessageUtil::formatReflector(reset($parameters)),
    ));
  }

  /**
   * @param \Ock\Ock\Formula\FreeParameters\Formula_FreeParametersInterface $formula
   * @param \Psr\Container\ContainerInterface $container
   * @param \Ock\Egg\ParamToEgg\ParamToEggInterface $paramToEgg
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface|null
   *   The adapted formula, or NULL if no free parameters were resolved.
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   *   One of the free parameters cannot be resolved.
   *   We need to abort here, to avoid infinite recursion.
   */
  #[Adapter]
  public static function adapt(
    #[Adaptee] Formula_FreeParametersInterface $formula,
    ContainerInterface $container,
    ParamToEggInterface $paramToEgg,
  ): ?FormulaInterface {
    $args = [];
    $parameters = $formula->getFreeParameters();
    try {
      foreach ($parameters as $index => $parameter) {
        $egg = $paramToEgg->paramGetEgg($parameter);
        if ($egg === NULL) {
          continue;
        }
        $args[$index] = $egg->hatch($container);
      }
    }
    catch (ToEggException|ContainerExceptionInterface $e) {
      throw new AdapterException(sprintf(
        'Cannot resolve %s.',
        MessageUtil::formatReflector($parameter),
      ), 0, $e);
    }
    if (!$args) {
      return NULL;
    }
    return $formula->withArgValues($args);
  }

}
