<?php

declare(strict_types=1);

namespace Ock\Ock;

use Ock\DependencyInjection\Provider\PackageServiceProviderBase;

class OckPackage extends PackageServiceProviderBase {

  const NAMESPACE = __NAMESPACE__;

  const DIR = __DIR__;

  const DISCOVERY_TARGET = 'ockDiscovery';

  const DISCOVERY_TAG_NAME = 'ock.discovery';

}
