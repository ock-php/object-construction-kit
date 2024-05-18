<?php

declare(strict_types=1);

namespace Donquixote\Ock\Plugin\Registry;

use Donquixote\ClassDiscovery\Discovery\DiscoveryInterface;
use Donquixote\Helpers\Util\MessageUtil;
use Donquixote\Ock\OckPackage;
use Donquixote\Ock\Plugin\PluginDeclaration;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\Target;

/**
 * The service is an empty instance.
 */
#[AsAlias(public: true)]
class PluginRegistry_Discovery implements PluginRegistryInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\ClassDiscovery\Discovery\DiscoveryInterface $discovery
   *   Discovery that returns plugin declarations.
   */
  public function __construct(
    #[Target(OckPackage::DISCOVERY_TARGET)]
    private readonly DiscoveryInterface $discovery,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getPluginsByType(): array {
    $pluginss = [];
    foreach ($this->discovery->getIterator() as $declaration) {
      assert($declaration instanceof PluginDeclaration, sprintf('Expected %s, found %s.', PluginDeclaration::class, MessageUtil::formatValue($declaration)));
      foreach ($declaration->getTypes() as $type) {
        $pluginss[$type][$declaration->getId()] = $declaration->getPlugin();
      }
    }
    return $pluginss;
  }

}
