<?php

declare(strict_types = 1);

use Ock\ClassDiscovery\FactsIA\FactsIAInterface;
use Ock\ClassDiscovery\FactsIA\FactsIA_InspectFactories;
use Ock\ClassDiscovery\Inspector\FactoryInspector_Concat;
use Ock\ClassDiscovery\Inspector\FactoryInspectorInterface;
use Ock\ClassDiscovery\ReflectionClassesIA\ReflectionClassesIA_Concat;
use Ock\ClassDiscovery\ReflectionClassesIA\ReflectionClassesIAInterface;
use Ock\Ock\OckPackage;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return function (ContainerConfigurator $container): void {
  $services = $container->services();

  $services->defaults()
    ->autowire()
    ->autoconfigure();

  $services->load('Ock\\Ock\\', 'src/');

  $discoveryClassesServiceId = ReflectionClassesIAInterface::class . ' $' . OckPackage::DISCOVERY_TARGET;
  $services->set($discoveryClassesServiceId)
    ->class(ReflectionClassesIA_Concat::class)
    ->factory([ReflectionClassesIA_Concat::class, 'fromCandidateObjects'])
    ->arg(0, tagged_iterator(OckPackage::DISCOVERY_TAG_NAME));

  $discoveryInspectorServiceId = FactoryInspectorInterface::class . ' $' . OckPackage::DISCOVERY_TARGET;
  $services->set($discoveryInspectorServiceId)
    ->class(FactoryInspector_Concat::class)
    ->factory([FactoryInspector_Concat::class, 'fromCandidateObjects'])
    ->arg(0, tagged_iterator(OckPackage::DISCOVERY_TAG_NAME));

  $services->set(FactsIAInterface::class . ' $' . OckPackage::DISCOVERY_TARGET)
    ->class(FactsIA_InspectFactories::class)
    ->arg(0, new Reference($discoveryClassesServiceId))
    ->arg(1, new Reference($discoveryInspectorServiceId));
};
