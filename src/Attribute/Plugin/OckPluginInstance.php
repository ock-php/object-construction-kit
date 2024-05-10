<?php

declare(strict_types=1);

namespace Donquixote\Ock\Attribute\Plugin;

use Donquixote\Helpers\Util\MessageUtil;
use Donquixote\DID\Attribute\Parameter\GetServiceInterface;
use Donquixote\DID\Attribute\ReflectorAwareAttributeInterface;
use Donquixote\DID\Exception\MalformedDeclarationException;
use Donquixote\DID\Util\AttributesUtil;
use Donquixote\DID\Util\ReflectionTypeUtil;
use Donquixote\Ock\Contract\FormulaHavingInterface;
use Donquixote\Ock\Contract\LabelHavingInterface;
use Donquixote\Ock\Contract\NameHavingInterface;
use Donquixote\Ock\Exception\FormulaException;
use Donquixote\Ock\Formula\Formula;
use Donquixote\Ock\Formula\Group\GroupFormulaBuilder;
use Donquixote\Ock\Formula\Iface\Formula_Iface;
use Donquixote\Ock\Plugin\PluginDeclaration;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Util\IdentifierLabelUtil;

/**
 * Marks a method or a class as producing a plugin instance.
 *
 * The target must be one of:
 * - An instantiable class.
 * - A public non-abstract static method with a return type that specifies a
 *   single class or interface name.
 *
 * At the moment, non-static methods are not supported.
 *
 * @see \Donquixote\Ock\Inspector\FactoryInspector_OckInstanceAttribute
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class OckPluginInstance extends PluginAttributeBase {

  /**
   * {@inheritdoc}
   */
  public function onClass(\ReflectionClass $reflectionClass): PluginDeclaration {
    if ($reflectionClass->isAbstract()) {
      throw new \RuntimeException(\sprintf(
        'Class %s must not be abstract.',
        $reflectionClass->getName(),
      ));
    }
    $types = $reflectionClass->getInterfaceNames();
    $formula = $this->buildGroupFormula($reflectionClass->getConstructor()?->getParameters() ?? [], $types)
      ->construct($reflectionClass->getName());
    return $this->formulaGetPluginDeclaration($formula, $types);
  }

  /**
   * {@inheritdoc}
   */
  public function onMethod(\ReflectionMethod $reflectionMethod): PluginDeclaration {
    if (!$reflectionMethod->isStatic()) {
      if ($reflectionMethod->isConstructor()) {
        throw new MalformedDeclarationException(\sprintf(
          'This attribute is not allowed on constructor %s. Put it on the class instead.',
          MessageUtil::formatReflector($reflectionMethod),
        ));
      }
      throw new MalformedDeclarationException(\sprintf(
        'This attribute is not allowed on non-static method %s. Consider making the method static.',
        MessageUtil::formatReflector($reflectionMethod),
      ));
    }
    $returnClass = ReflectionTypeUtil::requireGetClassLikeType($reflectionMethod);
    try {
      $reflectionReturnClass = new \ReflectionClass($returnClass);
    }
    catch (\ReflectionException) {
      throw new MalformedDeclarationException('Undefined class ' . $returnClass);
    }
    $types = $reflectionReturnClass->getInterfaceNames();
    if ($reflectionReturnClass->isInterface()) {
      $types = [$reflectionReturnClass->getName(), ...$types];
    }
    $formula = $this->buildGroupFormula($reflectionMethod->getParameters(), $types)
      ->call([
        $reflectionMethod->getDeclaringClass()->getName(),
        $reflectionMethod->getName(),
      ]);
    return $this->formulaGetPluginDeclaration($formula, $types);
  }

  /**
   * @param \ReflectionParameter[] $parameters
   * @param list<string> $types
   *
   * @return \Donquixote\Ock\Formula\Group\GroupFormulaBuilder
   *
   * @throws \Donquixote\DID\Exception\MalformedDeclarationException
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  private function buildGroupFormula(array $parameters): GroupFormulaBuilder {
    $builder = Formula::group();
    foreach ($parameters as $i => $parameter) {
      $attribute = AttributesUtil::getSingle($parameter, GetServiceInterface::class);
      if ($attribute !== NULL) {
        $serviceId = $attribute->paramGetServiceId($parameter);
        $builder->add(
          'service.' . $i,
          Text::i($i),
          Formula::serviceExpression($serviceId),
        );
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
      /** @var ReflectorAwareAttributeInterface $attribute */
      foreach (AttributesUtil::getAll($parameter, ReflectorAwareAttributeInterface::class) as $attribute) {
        $attribute->setReflector($parameter);
      }
    }
    return $builder;
  }

}
