<?php

declare(strict_types=1);

namespace Ock\Ock\Plugin\Registry;

use Ock\ClassDiscovery\FactsIA\FactsIAInterface;
use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\OckPackage;
use Ock\Ock\Plugin\PluginDeclaration;
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
   * @param \Ock\ClassDiscovery\FactsIA\FactsIAInterface $discovery
   *   Discovery that returns plugin declarations.
   */
  public function __construct(
    #[Target(OckPackage::DISCOVERY_TARGET)]
    private readonly FactsIAInterface $discovery,
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
