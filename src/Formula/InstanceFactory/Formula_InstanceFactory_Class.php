<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\InstanceFactory;

use Ock\Ock\V2V\Group\V2V_Group_Call;
use Ock\Ock\V2V\Group\V2V_GroupInterface;

class Formula_InstanceFactory_Class implements Formula_InstanceFactoryInterface {

  public function __construct(
    private readonly string $class,
  ) {}

  /**
   * @return \ReflectionParameter[]
   *
   * @throws \ReflectionException
   */
  public function getParameters(): array {
    return (new \ReflectionClass($this->class))
      ->getConstructor()?->getParameters() ?? [];
  }

  /**
   * @return \Ock\Ock\V2V\Group\V2V_GroupInterface
   */
  public function getV2V(): V2V_GroupInterface {
    return V2V_Group_Call::fromClass($this->class);
  }

}
