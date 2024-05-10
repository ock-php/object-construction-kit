<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests\Util;

use Donquixote\Adaptism\AdapterDefinitionList\AdapterDefinitionList_Discovery;
use Donquixote\Adaptism\AdaptismPackage;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\ClassDiscovery\ClassFilesIA\ClassFilesIA;
use Donquixote\ClassDiscovery\ClassFilesIA\ClassFilesIA_Concat;
use Donquixote\ClassDiscovery\ClassFilesIA\ClassFilesIAInterface;
use Donquixote\DID\Attribute\Service;
use Donquixote\DID\DidNamespace;
use Donquixote\Ock\Exception\FormulaException;
use Donquixote\Ock\OckPackage;
use Donquixote\Ock\Plugin\GroupLabels\PluginGroupLabels;
use Donquixote\Ock\Plugin\GroupLabels\PluginGroupLabelsInterface;
use Donquixote\Ock\Plugin\Registry\PluginRegistry_Discovery;
use Donquixote\Ock\Tests\Fixture\IntOp\IntOpInterface;
use Donquixote\Ock\Translator\Translator_Passthru;
use Donquixote\Ock\Translator\TranslatorInterface;
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
   * @return \Donquixote\ClassDiscovery\ClassFilesIA\ClassFilesIAInterface
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
   * @return \Donquixote\ClassDiscovery\ClassFilesIA\ClassFilesIAInterface
   * @throws \ReflectionException
   */
  #[Service(serviceIdSuffix: PluginRegistry_Discovery::class)]
  public static function getPluginClassFiles(): ClassFilesIAInterface {
    // Discover in fixtures dir only.
    return ClassFilesIA::psr4FromClass(IntOpInterface::class, 1);
  }

  /**
   * @return \Donquixote\Ock\Plugin\GroupLabels\PluginGroupLabelsInterface
   */
  #[Service]
  public static function getPluginGroupLabels(): PluginGroupLabelsInterface {
    return new PluginGroupLabels([]);
  }

  /**
   * @return \Donquixote\Ock\Translator\TranslatorInterface
   */
  #[Service]
  public static function getTranslator(): TranslatorInterface {
    return new Translator_Passthru();
  }

  /**
   * @return \Donquixote\ClassDiscovery\ClassFilesIA\ClassFilesIAInterface
   * @throws \ReflectionException
   */
  #[Service(serviceIdSuffix: AdapterDefinitionList_Discovery::class)]
  public static function getAdapterClassFilesIA(): ClassFilesIAInterface {
    return ClassFilesIA::psr4FromClass(OckPackage::class);
  }

}
