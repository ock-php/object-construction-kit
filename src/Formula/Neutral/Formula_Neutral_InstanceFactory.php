<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Neutral;

use Ock\ClassDiscovery\Exception\MalformedDeclarationException;
use Ock\ClassDiscovery\Util\AttributesUtil;
use Ock\ClassDiscovery\Util\ReflectionTypeUtil;
use Ock\Ock\Contract\FormulaHavingInterface;
use Ock\Ock\Contract\LabelHavingInterface;
use Ock\Ock\Contract\NameHavingInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Exception\FormulaException;
use Ock\Ock\Formula\Formula;
use Ock\Ock\Formula\Group\GroupFormulaBuilder;
use Ock\Ock\Formula\Iface\Formula_Iface;
use Ock\Ock\Util\IdentifierLabelUtil;
use Ock\Ock\Util\ReflectionUtil;

class Formula_Neutral_InstanceFactory extends Formula_Passthru_ProxyBase {

  /**
   * Constructor.
   *
   * @param callable(mixed...): object $factory
   */
  public function __construct(
    private readonly mixed $factory,
  ) {}

  /**
   * {@inheritdoc}
   */
  protected function doGetDecorated(): FormulaInterface {
    try {
      $reflector = ReflectionUtil::reflectCallable($this->factory);
      $parameters = $reflector->getParameters();
      return $this->buildGroupFormula($parameters)
        ->call($this->factory);
    }
    catch (\ReflectionException|MalformedDeclarationException $e) {
      throw new FormulaException($e->getMessage(), 0, $e);
    }
  }

  /**
   * @param \ReflectionParameter[] $parameters
   *
   * @return \Ock\Ock\Formula\Group\GroupFormulaBuilder
   *
   * @throws \Ock\ClassDiscovery\Exception\MalformedDeclarationException
   * @throws \Ock\Ock\Exception\FormulaException
   */
  private function buildGroupFormula(array $parameters): GroupFormulaBuilder {
    $builder = Formula::group();
    foreach ($parameters as $parameter) {
      $name = AttributesUtil::getSingle($parameter, NameHavingInterface::class)
        ?->getName()
        ?? $parameter->getName();
      $label = AttributesUtil::getSingle(
        $parameter,
        LabelHavingInterface::class,
      )?->getLabel()
        ?? IdentifierLabelUtil::fromInterface($name);
      $formula = AttributesUtil::getSingle(
        $parameter,
        FormulaHavingInterface::class,
      )?->getFormula()
        ?? new Formula_Iface(
          ReflectionTypeUtil::requireGetClassLikeType($parameter),
          $parameter->allowsNull(),
        );
      $builder->add($name, $label, $formula);
    }
    return $builder;
  }

}
