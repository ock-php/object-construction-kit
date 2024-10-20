<?php

declare(strict_types=1);

namespace Ock\Ock\Plugin\Registry;

use Ock\ClassDiscovery\FactsIA\FactsIAInterface;
use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\Plugin\PluginDeclaration;

/**
 * The service is an empty instance.
 */
class PluginRegistry_Discovery implements PluginRegistryInterface {

  /**
   * Constructor.
   *
   * @param \Ock\ClassDiscovery\FactsIA\FactsIAInterface<mixed, mixed> $discovery
   *   Discovery that returns plugin declarations.
   */
  public function __construct(
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
