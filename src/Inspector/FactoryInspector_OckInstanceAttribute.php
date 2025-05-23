<?php

declare(strict_types=1);

namespace Ock\Ock\Inspector;

use Ock\ClassDiscovery\Exception\MalformedDeclarationException;
use Ock\ClassDiscovery\Inspector\FactoryInspectorInterface;
use Ock\ClassDiscovery\Util\AttributesUtil;
use Ock\ClassDiscovery\Util\ReflectionTypeUtil;
use Ock\DependencyInjection\Attribute\ServiceTag;
use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\Attribute\Plugin\OckPluginInstance;
use Ock\Ock\Contract\FormulaHavingInterface;
use Ock\Ock\Contract\LabelHavingInterface;
use Ock\Ock\Contract\NameHavingInterface;
use Ock\Ock\Exception\FormulaException;
use Ock\Ock\Formula\Formula;
use Ock\Ock\Formula\Group\GroupFormulaBuilder;
use Ock\Ock\Formula\Iface\Formula_Iface;
use Ock\Ock\OckPackage;
use Ock\Ock\Plugin\Plugin;
use Ock\Ock\Plugin\PluginDeclaration;
use Ock\Ock\Text\Text;
use Ock\Ock\Util\IdentifierLabelUtil;
use Ock\Reflection\ClassReflection;
use Ock\Reflection\FactoryReflectionInterface;
use Ock\Reflection\MethodReflection;
use Ock\Reflection\ParameterReflection;
use Ock\ReflectorAwareAttributes\ReflectorAwareAttributeInterface;
use Psr\Container\ContainerInterface;

/**
 * Inspector that looks for instance factories.
 *
 * @template-implements FactoryInspectorInterface<int, PluginDeclaration>
 */
#[ServiceTag(OckPackage::DISCOVERY_TAG_NAME)]
class FactoryInspector_OckInstanceAttribute implements FactoryInspectorInterface {

  public function __construct(
    private readonly ContainerInterface $container,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function findInFactory(FactoryReflectionInterface $reflector): \Iterator {
    $attribute = AttributesUtil::getSingle($reflector->reveal(), OckPluginInstance::class);
    if ($attribute === null) {
      return;
    }
    if (!$reflector->isCallable()) {
      throw new MalformedDeclarationException(\sprintf(
        'Attribute %s is not allowed on %s.',
        get_class($attribute),
        $reflector->getDebugName(),
      ));
    }
    try {
      $resultClassReflection = $reflector->getReturnClass();
    }
    catch (\ReflectionException|\Error) {
      // Result class does not exist.
      // Ignore this declaration.
      return;
    }
    if ($resultClassReflection === null) {
      // At this point, $reflector must be a method.
      throw new MalformedDeclarationException(\sprintf(
        'Expected a class-like return type declaration on %s.',
        $reflector->getDebugName(),
      ));
    }
    $types = $resultClassReflection->getInterfaceNames();
    $builder = $this->buildGroupFormula($reflector->getParameters());
    if ($reflector instanceof ClassReflection) {
      $formula = $builder->construct($reflector->name);
    }
    elseif ($reflector instanceof MethodReflection) {
      if (!$reflector->isStatic()) {
        throw new MalformedDeclarationException(\sprintf(
          'This attribute is not allowed on non-static method %s. Consider making the method static.',
          MessageUtil::formatReflector($reflector),
        ));
      }
      $formula = $builder->call($reflector->getStaticCallableArray());
    }
    else {
      return;
    }

    $label = Text::tIf($attribute->label, $attribute->translate);
    $plugin = new Plugin($label, null, $formula, []);

    yield new PluginDeclaration($attribute->id, $types, $plugin);
  }

  /**
   * @param \Ock\Reflection\ParameterReflection[] $parameters
   *
   * @return \Ock\Ock\Formula\Group\GroupFormulaBuilder
   *
   * @throws \Ock\ClassDiscovery\Exception\DiscoveryException
   */
  private function buildGroupFormula(array $parameters): GroupFormulaBuilder {
    $builder = Formula::group();
    foreach ($parameters as $i => $parameter) {
      $name = AttributesUtil::getSingle($parameter, NameHavingInterface::class)
        ?->getName();
      if ($name === NULL) {
        $serviceId = $this->paramGetServiceId($parameter);
        $builder->add(
          'service.' . $i,
          Text::i($i),
          Formula::serviceExpression($serviceId),
        );
        continue;
      }
      $label = AttributesUtil::getSingle($parameter, LabelHavingInterface::class)
        ?->getLabel()
        ?? IdentifierLabelUtil::fromInterface($name);
      $formula = AttributesUtil::getSingle($parameter, FormulaHavingInterface::class)
        ?->getFormula()
        ?? new Formula_Iface(
          ReflectionTypeUtil::requireGetClassLikeType($parameter),
          $parameter->allowsNull(),
        );
      try {
        $builder->add($name, $label, $formula);
      }
      catch (FormulaException $e) {
        throw new MalformedDeclarationException(sprintf(
          'Problem on %s: %s.',
          MessageUtil::formatReflector($parameter),
          $e->getMessage(),
        ), 0, $e);
      }
      /** @var \Ock\ReflectorAwareAttributes\ReflectorAwareAttributeInterface $attribute */
      foreach (AttributesUtil::getAll($parameter, ReflectorAwareAttributeInterface::class) as $attribute) {
        $attribute->setReflector($parameter);
      }
    }
    return $builder;
  }

  /**
   * Gets a service id that would fit a parameter.
   *
   * @param \Ock\Reflection\ParameterReflection $parameter
   *
   * @return string
   *   A service id.
   */
  private function paramGetServiceId(ParameterReflection $parameter): string {
    $class = $parameter->getParamClassName();
    if ($class !== null) {
      $id = $class . ' $' . $parameter->name;
      if ($this->container->has($id)) {
        return $id;
      }
      $id = $class;
      if ($this->container->has($id)) {
        return $id;
      }
    }
    $id = $parameter->name;
    if ($this->container->has($id)) {
      return $id;
    }
    throw new \RuntimeException(sprintf(
      'Cannot find service id for %s.',
      $parameter->getDebugName(),
    ));
  }


}
