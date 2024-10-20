<?php

declare(strict_types=1);

namespace Ock\Ock\Inspector;

use Ock\ClassDiscovery\Exception\MalformedDeclarationException;
use Ock\ClassDiscovery\Inspector\FactoryInspectorInterface;
use Ock\ClassDiscovery\Reflection\FactoryReflectionInterface;
use Ock\ClassDiscovery\Reflection\MethodReflection;
use Ock\ClassDiscovery\Util\AttributesUtil;
use Ock\ClassDiscovery\Util\ReflectionTypeUtil;
use Ock\Ock\Attribute\Plugin\OckPluginFormula;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Neutral\Formula_Passthru_FormulaFactory;
use Ock\Ock\OckPackage;
use Ock\Ock\Plugin\Plugin;
use Ock\Ock\Plugin\PluginDeclaration;
use Ock\Ock\Text\Text;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * @template-implements FactoryInspectorInterface<int, PluginDeclaration>
 */
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

    $label = Text::tIf($attribute->label, $attribute->translate);
    $plugin = new Plugin($label, null, $formula, []);

    try {
      $rclass = new \ReflectionClass($attribute->type);
    }
    // The $attribute->type is annotated as class-string, but we don't want to
    // rely on it.
    // @phpstan-ignore catch.neverThrown
    catch (\ReflectionException $e) {
      throw new MalformedDeclarationException(sprintf(
        "Unknown type '%s' in attribute %s on %s.",
        $attribute->type,
        get_class($attribute),
        $reflector->getDebugName(),
      ), 0, $e);
    }

    $types = $rclass->getInterfaceNames();

    yield new PluginDeclaration($attribute->id, $types, $plugin);
  }

}
