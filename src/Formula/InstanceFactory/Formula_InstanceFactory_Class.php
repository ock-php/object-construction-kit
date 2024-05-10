<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\InstanceFactory;

use Donquixote\Ock\V2V\Group\V2V_Group_Call;
use Donquixote\Ock\V2V\Group\V2V_GroupInterface;

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
   * @return \Donquixote\Ock\V2V\Group\V2V_GroupInterface
   */
  public function getV2V(): V2V_GroupInterface {
    return V2V_Group_Call::fromClass($this->class);
  }

}
