<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests\Fixture;

use Donquixote\ClassDiscovery\ReflectionClassesIA\CurrentNamespaceBase;
use Donquixote\Ock\OckPackage;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(OckPackage::DISCOVERY_TAG_NAME)]
class OckTestNamespace extends CurrentNamespaceBase {

}
