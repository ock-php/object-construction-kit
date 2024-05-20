<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\InstanceFactory;

use Ock\Ock\V2V\Group\V2V_GroupInterface;

interface Formula_InstanceFactoryInterface {

  /**
   * @return \ReflectionParameter[]
   */
  public function getParameters(): array;

  /**
   * @return \Ock\Ock\V2V\Group\V2V_GroupInterface
   */
  public function getV2V(): V2V_GroupInterface;

}
