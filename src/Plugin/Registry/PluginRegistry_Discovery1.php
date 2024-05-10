<?php

declare(strict_types=1);

namespace Donquixote\Ock\Plugin\Registry;

use Donquixote\DID\Exception\MalformedDeclarationException;
use Donquixote\ClassDiscovery\Util\AttributesUtil;
use Donquixote\ClassDiscovery\ClassFilesIA\ClassFilesIAInterface;
use Donquixote\ClassDiscovery\Shared\ReflectionClassesIAHavingBase;
use Donquixote\DID\Attribute\Parameter\GetService;
use Donquixote\DID\Attribute\Service;
use Donquixote\Ock\Attribute\Plugin\PluginAttributeInterface;
use Donquixote\Ock\Attribute\PluginModifier\PluginModifierAttributeInterface;
use Donquixote\Ock\Exception\FormulaException;
use Donquixote\Ock\Exception\PluginListException;

/**
 * The service is an empty instance.
 */
#[Service(self::class)]
class PluginRegistry_Discovery1 extends ReflectionClassesIAHavingBase implements PluginRegistryInterface {

  /**
   * Gets the default non-empty instance.
   *
   * @param \Donquixote\Ock\Plugin\Registry\PluginRegistry_Discovery $emptyPluginRegistry
   * @param \Donquixote\ClassDiscovery\ClassFilesIA\ClassFilesIAInterface $classFilesIA
   *
   * @return self
   */
  #[Service(serviceIdSuffix: 'decorated')]
  public static function create(
    #[GetService]
    self $emptyPluginRegistry,
    #[Autowire(serviceIdSuffix: self::class)]
    ClassFilesIAInterface $classFilesIA,
  ): self {
    return $emptyPluginRegistry->withClassFilesIA($classFilesIA);
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginsByType(): array {
    $pluginss = [];
    try {
      /** @var \ReflectionClass $reflectionClass */
      foreach ($this->itReflectionClasses() as $reflectionClass) {
        $this->collectPlugins($pluginss, $reflectionClass);
        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
          $this->collectPlugins($pluginss, $reflectionMethod);
        }
      }
    }
    catch (MalformedDeclarationException|FormulaException|\ReflectionException $e) {
      throw new PluginListException('Bad plugin declarations: ' . $e->getMessage(), 0, $e);
    }
    return $pluginss;
  }

  /**
   * @param array<string, array<string, \Donquixote\Ock\Plugin\Plugin>> $pluginss
   * @param \ReflectionClass|\ReflectionMethod $reflector
   *
   * @throws \Donquixote\DID\Exception\MalformedDeclarationException
   * @throws \Donquixote\Ock\Exception\FormulaException
   * @throws \ReflectionException
   */
  private function collectPlugins(array &$pluginss, \ReflectionClass|\ReflectionMethod $reflector): void {
    $provider = AttributesUtil::getSingle($reflector, PluginAttributeInterface::class);
    if ($provider === null) {
      return;
    }
    $declaration = ($reflector instanceof \ReflectionClass)
      ? $provider->onClass($reflector)
      : $provider->onMethod($reflector);
    /**
     * @var PluginModifierAttributeInterface $modifier
     * @psalm-ignore-var
     */
    foreach (AttributesUtil::getAll($reflector, PluginModifierAttributeInterface::class) as $modifier) {
      $declaration = $modifier->modifyPlugin($declaration);
    }
    foreach ($declaration->getTypes() as $type) {
      $pluginss[$type][$declaration->getId()] = $declaration->getPlugin();
    }
  }

}
