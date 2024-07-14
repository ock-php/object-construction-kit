<?php

declare(strict_types=1);

namespace Ock\Ock\Plugin\Registry;

use Ock\ClassDiscovery\FactsIA\FactsIA;
use Ock\DependencyInjection\Attribute\Service;
use Ock\Ock\OckPackage;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

/**
 * Class with only static factories.
 */
class PluginRegistry {

  #[Service]
  public static function fromCandidateObjects(
    #[TaggedIterator(OckPackage::DISCOVERY_TAG_NAME)]
    iterable $objects,
  ): PluginRegistryInterface {
    $factsIA = FactsIA::fromCandidateObjects($objects);
    return new PluginRegistry_Discovery($factsIA);
  }

}
