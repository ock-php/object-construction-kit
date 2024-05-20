<?php

declare(strict_types = 1);

namespace Ock\Ock\Inspector;

use Ock\ClassDiscovery\Inspector\FactoryInspectorInterface;
use Ock\ClassDiscovery\Reflection\FactoryReflectionInterface;
use Ock\ClassDiscovery\Util\AttributesUtil;
use Ock\Ock\Attribute\PluginModifier\PluginModifierAttributeInterface;
use Ock\Ock\OckPackage;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(FactoryInspectorInterface::class . ' $' . OckPackage::DISCOVERY_TARGET)]
class FactoryInspector_ModifierDecorator implements FactoryInspectorInterface {

  public function __construct(
    private readonly FactoryInspectorInterface $decorated,
  ) {}

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
