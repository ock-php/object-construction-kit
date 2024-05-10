<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests;

use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\ClassDiscovery\NamespaceDirectory;
use Donquixote\Ock\Formula\Formula;
use Donquixote\Ock\Formula\Sequence\Formula_SequenceInterface;
use Donquixote\Ock\Generator\Generator;
use Donquixote\Ock\Generator\Generator_Neutral;
use Donquixote\Ock\Generator\GeneratorInterface;
use Donquixote\Ock\OckNamespace;
use Donquixote\Ock\Plugin\Plugin;
use Donquixote\Ock\Plugin\Registry\PluginRegistryInterface;
use Donquixote\Ock\Tests\Fixture\IntCondition\IntCondition_GreaterThan;
use Donquixote\Ock\Tests\Fixture\IntCondition\IntConditionInterface;
use Donquixote\Ock\Tests\Fixture\IntOp\IntOpInterface;
use Donquixote\Ock\Tests\Util\TestingServices;
use Donquixote\Ock\Text\Text;

class DiscoveryTest extends FormulaTestBase {

  /**
   * Tests that class files in the package are discovered.
   */
  public function testClassFilesIA() {
    $root = dirname(__DIR__, 2);
    $classFilesIA = NamespaceDirectory::fromKnownClass(OckNamespace::class);
    $class_files = iterator_to_array($classFilesIA);

    self::assertSame(
      $class_files[$root . '/src/Generator/Generator_Neutral.php'] ?? NULL,
      Generator_Neutral::class);

    self::assertSame(
      $class_files[$root . '/src/Formula/Sequence/Formula_SequenceInterface.php'] ?? NULL,
      Formula_SequenceInterface::class);
  }

  /**
   * Tests plugin discovery.
   *
   * @throws \Donquixote\Ock\Exception\GeneratorException
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   * @throws \Donquixote\Ock\Exception\PluginListException
   * @throws \Donquixote\DID\Exception\ContainerToValueException
   */
  public function testPluginDiscovery(): void {
    $container = TestingServices::getContainer();
    /** @var \Donquixote\Ock\Plugin\Registry\PluginRegistryInterface $registry */
    $registry = $container->get(PluginRegistryInterface::class);
    $pluginss = $registry->getPluginsByType();

    $adapter = $container->get(UniversalAdapterInterface::class);

    $pluginss_by_id = [];
    foreach ($pluginss as $type => $plugins) {
      foreach ($plugins as $id => $plugin) {
        static::assertInstanceOf(
          Plugin::class,
          $plugin,
          "\$pluginss['$type']['$id'] instanceof Plugin.",
        );
        $generator = $adapter->adapt($plugin->getFormula(), GeneratorInterface::class);
        static::assertNotNull(
          $generator,
          "Generator created for \$pluginss['$type']['$id'].",
        );
        $pluginss_by_id[$id][$type] = $plugin;
      }
    }

    $plugin = $pluginss[IntConditionInterface::class]['positive'] ?? NULL;

    # self::assertSame([], $pluginss_by_id['positive']);

    self::assertNotNull($plugin, 'Plugin for IntConditionInterface/positive.');

    self::assertEquals(
      Text::t('Number is positive'),
      $plugin->getLabel());

    $formula = $plugin->getFormula();
    $generator = Generator::fromFormula(
      $formula,
      $adapter);

    self::assertSame(
      '\\' . IntCondition_GreaterThan::class . '::positive()',
      $generator->confGetPhp(NULL));

    $formula = Formula::iface(IntOpInterface::class);

    $generator = Generator::fromFormula($formula, $adapter);

    self::assertNotNull($generator, 'Generator not NULL.');
  }

}
