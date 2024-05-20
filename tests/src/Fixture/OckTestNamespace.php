<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Fixture;

use Ock\ClassDiscovery\ReflectionClassesIA\CurrentNamespaceBase;
use Ock\Ock\OckPackage;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(OckPackage::DISCOVERY_TAG_NAME)]
class OckTestNamespace extends CurrentNamespaceBase {

}
