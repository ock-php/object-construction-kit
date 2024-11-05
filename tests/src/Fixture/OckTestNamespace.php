<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Fixture;

use Ock\ClassDiscovery\ReflectionClassesIA\CurrentNamespaceBase;
use Ock\DependencyInjection\Attribute\ServiceTag;
use Ock\Ock\OckPackage;

#[ServiceTag(OckPackage::DISCOVERY_TAG_NAME)]
class OckTestNamespace extends CurrentNamespaceBase {

}
