<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Util;

use Ock\Adaptism\AdapterDefinitionList\AdapterDefinitionList_Discovery;
use Ock\Adaptism\AdaptismPackage;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\ClassDiscovery\ClassFilesIA\ClassFilesIA;
use Ock\ClassDiscovery\ClassFilesIA\ClassFilesIA_Concat;
use Ock\ClassDiscovery\ClassFilesIA\ClassFilesIAInterface;
use Ock\DID\Attribute\Service;
use Ock\DID\DidNamespace;
use Ock\Ock\Exception\FormulaException;
use Ock\Ock\OckPackage;
use Ock\Ock\Plugin\GroupLabels\PluginGroupLabels;
use Ock\Ock\Plugin\GroupLabels\PluginGroupLabelsInterface;
use Ock\Ock\Plugin\Registry\PluginRegistry_Discovery;
use Ock\Ock\Tests\Fixture\IntOp\IntOpInterface;
use Ock\Ock\Translator\Translator_Passthru;
use Ock\Ock\Translator\TranslatorInterface;
use Ock\Egg\EggNamespace;
use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

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
    static::loadPackageServicesPhp($container, dirname(DidNamespace::DIR));
    static::loadPackageServicesPhp($container, dirname(EggNamespace::DIR));
    static::loadPackageServicesPhp($container, dirname(AdaptismPackage::DIR));
    static::loadPackageServicesPhp($container, dirname(OckPackage::DIR));
    static::loadPackageServicesPhp($container, dirname(__DIR__, 2), 'services.test.php');
    $container->setAlias(ContainerInterface::class, 'service_container');

    $container->compile();

    return $container;
  }

  /**
   * Loads services from a services.php in a package directory.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
   * @param string $dir
   *   Directory where the services.php is found.
   * @param string $file
   *   File name.
   */
  protected static function loadPackageServicesPhp(ContainerBuilder $container, string $dir, string $file = 'services.php'): void {
    $locator = new FileLocator($dir);
    $loader = new PhpFileLoader($container, $locator);
    $loader->load($file);
  }

  /**
   * @return \Ock\ClassDiscovery\ClassFilesIA\ClassFilesIAInterface
   *
   * @throws \ReflectionException
   */
  public static function getServiceDiscoveryLocations(): ClassFilesIAInterface {
    return new ClassFilesIA_Concat([
      // Discover in object-construction-kit.
      ClassFilesIA::psr4FromClass(FormulaException::class, 1),
      // Discover in object-construction-kit/tests.
      ClassFilesIA::psr4FromClass(self::class),
      // Discover in adaptism.
      ClassFilesIA::psr4FromClass(UniversalAdapterInterface::class, 1),
    ]);
  }

  /**
   * @return \Ock\ClassDiscovery\ClassFilesIA\ClassFilesIAInterface
   * @throws \ReflectionException
   */
  #[Service(serviceIdSuffix: PluginRegistry_Discovery::class)]
  public static function getPluginClassFiles(): ClassFilesIAInterface {
    // Discover in fixtures dir only.
    return ClassFilesIA::psr4FromClass(IntOpInterface::class, 1);
  }

  /**
   * @return \Ock\Ock\Plugin\GroupLabels\PluginGroupLabelsInterface
   */
  #[Service]
  public static function getPluginGroupLabels(): PluginGroupLabelsInterface {
    return new PluginGroupLabels([]);
  }

  /**
   * @return \Ock\Ock\Translator\TranslatorInterface
   */
  #[Service]
  public static function getTranslator(): TranslatorInterface {
    return new Translator_Passthru();
  }

  /**
   * @return \Ock\ClassDiscovery\ClassFilesIA\ClassFilesIAInterface
   * @throws \ReflectionException
   */
  #[Service(serviceIdSuffix: AdapterDefinitionList_Discovery::class)]
  public static function getAdapterClassFilesIA(): ClassFilesIAInterface {
    return ClassFilesIA::psr4FromClass(OckPackage::class);
  }

}
