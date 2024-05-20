<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\InstanceFactory;

use Ock\Ock\Exception\FormulaException;
use Ock\Ock\V2V\Group\V2V_Group_Call;
use Ock\Ock\V2V\Group\V2V_GroupInterface;

class Formula_InstanceFactory_StaticMethod implements Formula_InstanceFactoryInterface {

  /**
   * Constructor.
   *
   * @param callable&array{class-string, string} $method
   */
  public function __construct(
    private readonly array $method,
  ) {}

  /**
   * @return \ReflectionParameter[]
   *
   * @throws \ReflectionException
   */
  public function getParameters(): array {
    return (new \ReflectionMethod(...$this->method))
      ->getParameters();
  }

  /**
   * @return \Ock\Ock\V2V\Group\V2V_GroupInterface
   */
  public function getV2V(): V2V_GroupInterface {
    try {
      return V2V_Group_Call::fromCallable($this->method);
    }
    catch (\ReflectionException $e) {
      throw new FormulaException($e->getMessage(), 0, $e);
    }
  }

}
