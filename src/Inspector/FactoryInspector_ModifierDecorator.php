<?php

declare(strict_types = 1);

namespace Ock\Ock\Inspector;

use Ock\ClassDiscovery\Inspector\FactoryInspectorInterface;
use Ock\ClassDiscovery\Reflection\FactoryReflectionInterface;
use Ock\ClassDiscovery\Util\AttributesUtil;
use Ock\DependencyInjection\Attribute\Service;
use Ock\DependencyInjection\Attribute\ServiceTag;
use Ock\Ock\Attribute\PluginModifier\PluginModifierAttributeInterface;
use Ock\Ock\OckPackage;

class FactoryInspector_ModifierDecorator implements FactoryInspectorInterface {

  public function __construct(
    private readonly FactoryInspectorInterface $decorated,
  ) {}

  #[Service]
  #[ServiceTag(OckPackage::DISCOVERY_TAG_NAME)]
  public static function createDecoratorCallback(): \Closure {
    return fn (FactoryInspectorInterface $inspector): self => new self($inspector);
  }

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
