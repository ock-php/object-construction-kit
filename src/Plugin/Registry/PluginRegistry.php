<?php

declare(strict_types=1);

namespace Ock\Ock\Plugin\Registry;

use Ock\ClassDiscovery\FactsIA\FactsIA;
use Ock\DependencyInjection\Attribute\Service;
use Ock\Ock\OckPackage;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

/**
 * Class with only static factories.
 */
class PluginRegistry {

  /**
   * @param iterable<object> $objects
   *
   * @return \Ock\Ock\Plugin\Registry\PluginRegistryInterface
   */
  #[Service]
  public static function fromCandidateObjects(
    #[AutowireIterator(OckPackage::DISCOVERY_TAG_NAME)]
    iterable $objects,
  ): PluginRegistryInterface {
    $factsIA = FactsIA::fromCandidateObjects($objects);
    return new PluginRegistry_Discovery($factsIA);
  }

}
