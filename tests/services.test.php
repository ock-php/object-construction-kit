<?php

/**
 * @file
 */

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container): void {
  $services = $container->services();

  $services->defaults()
    ->autowire()
    ->autoconfigure();

  // The path is relative to the directory where 'services.php' is located.
  $services->load('Ock\\Ock\\Tests\\Fixture\\', 'src/Fixture/');
};
