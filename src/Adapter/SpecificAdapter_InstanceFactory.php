<?php

declare(strict_types=1);

namespace Ock\Ock\Adapter;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Attribute\Parameter\UniversalAdapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\ClassDiscovery\Util\AttributesUtil;
use Ock\ClassDiscovery\Util\ReflectionTypeUtil;
use Ock\Ock\Contract\FormulaHavingInterface;
use Ock\Ock\Contract\LabelHavingInterface;
use Ock\Ock\Contract\NameHavingInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Formula;
use Ock\Ock\Formula\Group\GroupFormulaBuilder;
use Ock\Ock\Formula\Iface\Formula_Iface;
use Ock\Ock\Formula\InstanceFactory\Formula_InstanceFactoryInterface;
use Ock\Ock\Util\IdentifierLabelUtil;

class SpecificAdapter_InstanceFactory {

  /**
   * @param \Ock\Ock\Formula\InstanceFactory\Formula_InstanceFactoryInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface|null
   *
   * @throws \Ock\ClassDiscovery\Exception\MalformedDeclarationException
   * @throws \Ock\Ock\Exception\FormulaException
   */
  #[Adapter]
  public function adapt(
    #[Adaptee] Formula_InstanceFactoryInterface $formula,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
  ): ?FormulaInterface {
    $parameters = $formula->getParameters();
    return $this->buildGroupFormula($parameters)
      ->buildGroupValFormula($formula->getV2V());
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
      $label = AttributesUtil::getSingle($parameter, LabelHavingInterface::class)
        ?->getLabel()
        ?? IdentifierLabelUtil::fromInterface($name);
      $formula = AttributesUtil::getSingle($parameter, FormulaHavingInterface::class)
        ?->getFormula()
        ?? new Formula_Iface(
          ReflectionTypeUtil::requireGetClassLikeType($parameter),
          $parameter->allowsNull(),
        );
      $builder->add($name, $label, $formula);
    }
    return $builder;
  }

}
