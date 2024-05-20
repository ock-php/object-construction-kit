<?php

declare(strict_types=1);

namespace Ock\Ock;

use Ock\Adaptism\AdaptismPackage;
use Ock\ClassDiscovery\ReflectionClassesIA\CurrentNamespaceBase;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * Classes to scan for adapter definitions.
 */
#[AutoconfigureTag(AdaptismPackage::DISCOVERY_TAG_NAME)]
class OckNamespace extends CurrentNamespaceBase {

}
