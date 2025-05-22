<?php

declare(strict_types = 1);

namespace Ock\Ock\Inspector;

use Ock\ClassDiscovery\Inspector\FactoryInspectorInterface;
use Ock\ClassDiscovery\Util\AttributesUtil;
use Ock\DependencyInjection\Attribute\Service;
use Ock\DependencyInjection\Attribute\ServiceTag;
use Ock\Ock\Attribute\PluginModifier\PluginModifierAttributeInterface;
use Ock\Ock\OckPackage;
use Ock\Reflection\FactoryReflectionInterface;

/**
 * @template TKey
 *
 * @template-implements FactoryInspectorInterface<TKey, \Ock\Ock\Plugin\PluginDeclaration>
 */
class FactoryInspector_ModifierDecorator implements FactoryInspectorInterface {

  /**
   * Constructor.
   *
   * @param \Ock\ClassDiscovery\Inspector\FactoryInspectorInterface<TKey, \Ock\Ock\Plugin\PluginDeclaration> $decorated
   */
  public function __construct(
    private readonly FactoryInspectorInterface $decorated,
  ) {}

  #[Service]
  #[ServiceTag(OckPackage::DISCOVERY_TAG_NAME)]
  public static function createDecoratorCallback(): \Closure {
    return fn (FactoryInspectorInterface $inspector): self => new self($inspector);
  }

  /**
   * {@inheritdoc}
   */
  public function findInFactory(FactoryReflectionInterface $reflector): \Iterator {
    foreach ($this->decorated->findInFactory($reflector) as $key => $declaration) {
      $modifierAttributes ??= AttributesUtil::getAll($reflector, PluginModifierAttributeInterface::class);
      foreach ($modifierAttributes as $modifier) {
        $declaration = $modifier->modifyPlugin($declaration);
      }
      yield $key => $declaration;
    }
  }

}
