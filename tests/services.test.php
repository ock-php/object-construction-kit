<?php

/**
 * @file
 */

declare(strict_types=1);

use Ock\Ock\Tests\Fixture\OckTestPackage;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container): void {
  OckTestPackage::configureServices($container);
};
