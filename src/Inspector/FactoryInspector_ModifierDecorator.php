<?php

declare(strict_types = 1);

namespace Donquixote\Ock\Inspector;

use Donquixote\ClassDiscovery\Inspector\FactoryInspectorInterface;
use Donquixote\ClassDiscovery\Reflection\FactoryReflectionInterface;
use Donquixote\ClassDiscovery\Util\AttributesUtil;
use Donquixote\Ock\Attribute\PluginModifier\PluginModifierAttributeInterface;
use Donquixote\Ock\OckPackage;
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
