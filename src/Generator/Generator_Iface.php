<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Attribute\Parameter\UniversalAdapter;
use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\CodegenTools\Util\PhpUtil;
use Ock\DID\Attribute\Parameter\GetService;
use Ock\Ock\Exception\GeneratorException;
use Ock\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Ock\Ock\Exception\PluginListException;
use Ock\Ock\Formula\Iface\Formula_IfaceInterface;
use Ock\Ock\Plugin\Map\PluginMapInterface;

#[Adapter]
class Generator_Iface implements GeneratorInterface {

  /**
   * @var string
   */
  private string $type;

  /**
   * @var bool
   */
  private bool $allowsNull;

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Iface\Formula_IfaceInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   * @param \Ock\Ock\Plugin\Map\PluginMapInterface $pluginMap
   */
  public function __construct(
    #[Adaptee]
    Formula_IfaceInterface $formula,
    #[UniversalAdapter]
    private readonly UniversalAdapterInterface $universalAdapter,
    #[GetService]
    private readonly PluginMapInterface $pluginMap,
  ) {
    $this->type = $formula->getInterface();
    $this->allowsNull = $formula->allowsNull();
  }

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {
    $id = $conf['id'] ?? NULL;
    $subConf = $conf['options'] ?? NULL;
    $decoratorsConf = $conf['decorators'] ?? [];

    if ($id === NULL) {
      if ($this->allowsNull) {
        return 'NULL';
      }
      throw new GeneratorException_IncompatibleConfiguration('Required id is missing.');
    }

    try {
      $plugins = $this->pluginMap->typeGetPlugins($this->type);
    }
    catch (PluginListException $e) {
      throw new GeneratorException($e->getMessage(), 0, $e);
    }

    $plugin = $plugins[$id] ?? NULL;

    if ($plugin === NULL) {
      throw new GeneratorException_IncompatibleConfiguration(sprintf(
        'Unknown plugin id %s.',
        $id,
      ));
    }

    try {
      $php = Generator::fromFormula(
        $plugin->getFormula(),
        $this->universalAdapter,
      )->confGetPhp($subConf);
    }
    catch (AdapterException $e) {
      // @todo Add configuration and type into the exception.
      throw new GeneratorException($e->getMessage(), 0, $e);
    }

    if (!$decoratorsConf) {
      return $php;
    }

    $decoGenerator = clone $this;
    $decoGenerator->type = 'decorator<' . $this->type . '>';
    $decoGenerator->allowsNull = FALSE;

    foreach ($decoratorsConf as $decoratorConf) {
      $decoratorPhp = $decoGenerator->confGetPhp($decoratorConf);
      $php = PhpUtil::phpDecorate($php, $decoratorPhp);
    }

    return $php;
  }

}
