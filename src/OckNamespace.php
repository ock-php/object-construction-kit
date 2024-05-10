<?php

declare(strict_types=1);

namespace Donquixote\Ock;

use Donquixote\Adaptism\AdaptismPackage;
use Donquixote\ClassDiscovery\ReflectionClassesIA\CurrentNamespaceBase;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * Classes to scan for adapter definitions.
 */
#[AutoconfigureTag(AdaptismPackage::DISCOVERY_TAG_NAME)]
class OckNamespace extends CurrentNamespaceBase {

}
