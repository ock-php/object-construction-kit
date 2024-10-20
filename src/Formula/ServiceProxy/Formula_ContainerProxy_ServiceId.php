<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\ServiceProxy;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Exception\FormulaException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

class Formula_ContainerProxy_ServiceId implements Formula_ContainerProxyInterface {

  /**
   * Constructor.
   *
   * @param string $serviceId
   */
  public function __construct(
    private readonly string $serviceId,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function containerGetFormula(ContainerInterface $container): FormulaInterface {
    try {
      $formula = $container->get($this->serviceId);
      if (!$formula instanceof FormulaInterface) {
        throw new FormulaException(sprintf(
          "Expected a formula for service id '%s', found %s",
          $this->serviceId,
          get_debug_type($formula),
        ));
      }
      return $formula;
    }
    catch (ContainerExceptionInterface $e) {
      throw new FormulaException("Failed to get service '$this->serviceId'.", 0, $e);
    }
  }

}
