<?php

declare(strict_types=1);

namespace Donquixote\Ock\Inspector;

use Donquixote\ClassDiscovery\Exception\MalformedDeclarationException;
use Donquixote\ClassDiscovery\Inspector\FactoryInspectorInterface;
use Donquixote\ClassDiscovery\Reflection\ClassReflection;
use Donquixote\ClassDiscovery\Reflection\FactoryReflectionInterface;
use Donquixote\ClassDiscovery\Reflection\MethodReflection;
use Donquixote\ClassDiscovery\Util\AttributesUtil;
use Donquixote\ClassDiscovery\Util\ReflectionTypeUtil;
use Donquixote\Helpers\Util\MessageUtil;
use Donquixote\DID\Attribute\Parameter\GetServiceInterface;
use Donquixote\ClassDiscovery\Attribute\ReflectorAwareAttributeInterface;
use Donquixote\Ock\Attribute\Plugin\OckPluginInstance;
use Donquixote\Ock\Attribute\PluginModifier\PluginModifierAttributeInterface;
use Donquixote\Ock\Contract\FormulaHavingInterface;
use Donquixote\Ock\Contract\LabelHavingInterface;
use Donquixote\Ock\Contract\NameHavingInterface;
use Donquixote\Ock\Exception\FormulaException;
use Donquixote\Ock\Exception\GroupFormulaDuplicateKeyException;
use Donquixote\Ock\Formula\Formula;
use Donquixote\Ock\Formula\Group\GroupFormulaBuilder;
use Donquixote\Ock\Formula\Iface\Formula_Iface;
use Donquixote\Ock\OckPackage;
use Donquixote\Ock\Plugin\Plugin;
use Donquixote\Ock\Plugin\PluginDeclaration;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Util\IdentifierLabelUtil;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * Inspector that looks for instance factories.
 */
#[AutoconfigureTag(OckPackage::DISCOVERY_TAG_NAME)]
class FactoryInspector_OckInstanceAttribute implements FactoryInspectorInterface {

  /**
   * {@inheritdoc}
   */
  public function findInFactory(FactoryReflectionInterface $reflector): \Iterator {
    $attribute = AttributesUtil::getSingle($reflector, OckPluginInstance::class);
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

    $plugin = new Plugin($attribute->getLabel(), null, $formula, []);

    $declaration = new PluginDeclaration($attribute->id, $types, $plugin);

    // @todo Move the modifier handling to a decorating inspector.
    foreach (AttributesUtil::getAll($reflector, PluginModifierAttributeInterface::class) as $modifier) {
      # $declaration = $modifier->modifyPlugin($declaration);
    }

    yield $declaration;
  }

  /**
   * @param \ReflectionParameter[] $parameters
   *
   * @return \Donquixote\Ock\Formula\Group\GroupFormulaBuilder
   *
   * @throws \Donquixote\ClassDiscovery\Exception\DiscoveryException
   */
  private function buildGroupFormula(array $parameters): GroupFormulaBuilder {
    $builder = Formula::group();
    foreach ($parameters as $i => $parameter) {
      $attribute = AttributesUtil::getSingle($parameter, GetServiceInterface::class);
      if ($attribute !== NULL) {
        $serviceId = $attribute->paramGetServiceId($parameter);
        try {
          $builder->add(
            'service.' . $i,
            Text::i($i),
            Formula::serviceExpression($serviceId),
          );
        }
        catch (GroupFormulaDuplicateKeyException $e) {
          // Convert to unhandled exception, because this would be a programming
          // error within this package.
          throw new \RuntimeException(sprintf(
            'Unreachable code: Duplicate group formula key %s for parameter %s.',
            'service.' . $i,
            MessageUtil::formatReflector($parameter),
          ), 0, $e);
        }
        continue;
      }
      $name = AttributesUtil::requireSingle($parameter, NameHavingInterface::class)
        ->getName();
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
      /** @var \Donquixote\ClassDiscovery\Attribute\ReflectorAwareAttributeInterface $attribute */
      foreach (AttributesUtil::getAll($parameter, ReflectorAwareAttributeInterface::class) as $attribute) {
        $attribute->setReflector($parameter);
      }
    }
    return $builder;
  }

}
