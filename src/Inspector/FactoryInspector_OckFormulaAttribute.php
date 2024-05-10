<?php

declare(strict_types=1);

namespace Donquixote\Ock\Inspector;

use Donquixote\DID\Exception\MalformedDeclarationException;
use Donquixote\ClassDiscovery\Inspector\FactoryInspectorInterface;
use Donquixote\ClassDiscovery\Reflection\FactoryReflectionInterface;
use Donquixote\ClassDiscovery\Reflection\MethodReflection;
use Donquixote\DID\Util\AttributesUtil;
use Donquixote\DID\Util\ReflectionTypeUtil;
use Donquixote\Ock\Attribute\Plugin\OckPluginFormula;
use Donquixote\Ock\Attribute\PluginModifier\PluginModifierAttributeInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Neutral\Formula_Passthru_FormulaFactory;
use Donquixote\Ock\OckPackage;
use Donquixote\Ock\Plugin\Plugin;
use Donquixote\Ock\Plugin\PluginDeclaration;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(OckPackage::DISCOVERY_TAG_NAME)]
class FactoryInspector_OckFormulaAttribute implements FactoryInspectorInterface {

  /**
   * {@inheritdoc}
   */
  public function findInFactory(FactoryReflectionInterface $reflector): \Iterator {
    if (!$reflector instanceof MethodReflection
      || $reflector->isInherited()
    ) {
      return;
    }
    $attribute = AttributesUtil::getSingle($reflector, OckPluginFormula::class);
    if ($attribute === null) {
      return;
    }
    if (!$reflector->isCallable() || !$reflector->isStatic()) {
      throw new MalformedDeclarationException(\sprintf(
        'Attribute %s is not allowed on %s.',
        get_class($attribute),
        $reflector->getDebugName(),
      ));
    }
    $returnClass = ReflectionTypeUtil::requireGetClassLikeType($reflector);
    if (!\is_a($returnClass, FormulaInterface::class, true)) {
      throw new MalformedDeclarationException(\sprintf(
        'Unexpected return type on %s.',
        $reflector->getDebugName(),
      ));
    }
    $formula = new Formula_Passthru_FormulaFactory([
      $reflector->class,
      $reflector->name,
    ]);

    $plugin = new Plugin($attribute->getLabel(), null, $formula, []);

    try {
      $rclass = new \ReflectionClass($attribute->type);
    }
    catch (\ReflectionException $e) {
      throw new MalformedDeclarationException(sprintf(
        "Unknown type '%s' in attribute %s on %s.",
        $attribute->type,
        get_class($attribute),
        $reflector->getDebugName(),
      ), 0, $e);
    }

    $types = $rclass->getInterfaceNames();
    $declaration = new PluginDeclaration($attribute->id, $types, $plugin);

    // @todo Move the modifier handling to a decorating inspector.
    foreach (AttributesUtil::getAll($reflector, PluginModifierAttributeInterface::class) as $modifier) {
      # $declaration = $modifier->modifyPlugin($declaration);
    }

    yield $declaration;
  }

}
