<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Util;

use Ock\Adaptism\AdaptismPackage;
use Ock\DependencyInjection\Provider\CommonServiceProvider;
use Ock\Egg\EggPackage;
use Ock\Ock\OckPackage;
use Ock\Ock\Tests\Fixture\OckTestPackage;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Static method to create a container with common services for testing.
 */
class TestingServices {

  /**
   * @var \Psr\Container\ContainerInterface|null
   */
  private static ?ContainerInterface $container;

  /**
   * Builds a container with services for adaptism tests.
   *
   * @return \Psr\Container\ContainerInterface
   *   New container.
   */
  public static function getContainer(): ContainerInterface {
    return self::$container ??= self::buildContainer();
  }

  /**
   * @return \Psr\Container\ContainerInterface
   */
  private static function buildContainer(): ContainerInterface {
    $container = new ContainerBuilder();
    (new CommonServiceProvider())->register($container);
    (new EggPackage())->register($container);
    (new AdaptismPackage())->register($container);
    (new OckPackage())->register($container);
    (new OckTestPackage())->register($container);

    $container->compile();

    return $container;
  }

}
