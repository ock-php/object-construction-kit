<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\Parameter;

use Ock\Ock\Contract\FormulaHavingInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\ServiceProxy\Formula_ContainerProxy_ServiceId;

#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class OckFormulaFromService implements FormulaHavingInterface {

  /**
   * Constructor.
   *
   * @param string $serviceId
   */
  public function __construct(
    private readonly string $serviceId,
  ) {}

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getFormula(): FormulaInterface {
    return new Formula_ContainerProxy_ServiceId($this->serviceId);
  }

}
