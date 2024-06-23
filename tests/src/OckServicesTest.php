<?php

declare(strict_types=1);

namespace Ock\Ock\Tests;

use Ock\Ock\Tests\Util\TestingServices;
use Ock\Testing\Exporter\Exporter_ToYamlArray;
use Ock\Testing\RecordedTestTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class OckServicesTest extends TestCase {

  use RecordedTestTrait;

  public function testServices(): void {
    $container = TestingServices::getContainer();
    static::assertInstanceOf(ContainerBuilder::class, $container);
    $ids = $container->getServiceIds();
    \sort($ids);
    $export = [];
    foreach ($ids as $id) {
      if (!$container->has($id)) {
        $export[$id] = null;
        continue;
      }
      try {
        $export[$id] = null;
      }
      catch (ServiceNotFoundException $e) {
        $export[$id] = $e;
      }
    }
    $this->assertAsRecorded($export, 'services', 8);
  }

  /**
   * {@inheritdoc}
   */
  protected function createExporter(): Exporter_ToYamlArray {
    return (new Exporter_ToYamlArray())
      ->withDedicatedExporter(ContainerBuilder::class, fn (
        ContainerBuilder $builder,
      ) => ['class' => \get_class($builder)])
      ->withObjectGetters(Alias::class)
      ->withObjectGetters(Definition::class, ['isPrivate()', 'getChanges()'])
      ->withReferenceObject(new Alias('#'))
      ->withReferenceObjectFactory(
        Definition::class,
        fn (string|int|null $key) => (new Definition(is_string($key) ? $key : null))
          ->setAutoconfigured(true)
          ->setAutowired(true),
      );
  }

}
