<?php

declare(strict_types=1);

namespace Donquixote\Ock\Generator;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\Adaptism\Attribute\Parameter\UniversalAdapter;
use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\CodegenTools\Util\PhpUtil;
use Donquixote\DID\Attribute\Parameter\GetService;
use Donquixote\Ock\Exception\GeneratorException;
use Donquixote\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Donquixote\Ock\Exception\PluginListException;
use Donquixote\Ock\Formula\Iface\Formula_IfaceInterface;
use Donquixote\Ock\Plugin\Map\PluginMapInterface;

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
   * @param \Donquixote\Ock\Formula\Iface\Formula_IfaceInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   * @param \Donquixote\Ock\Plugin\Map\PluginMapInterface $pluginMap
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
