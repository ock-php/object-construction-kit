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
      return $container->get($this->serviceId);
    }
    catch (ContainerExceptionInterface $e) {
      throw new FormulaException($e->getMessage(), 0, $e);
    }
  }

}
