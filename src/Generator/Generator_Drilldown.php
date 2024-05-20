<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Attribute\Parameter\UniversalAdapter;
use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\DrilldownKeysHelper\DrilldownKeysHelper;
use Ock\Ock\Exception\FormulaException;
use Ock\Ock\Exception\GeneratorException;
use Ock\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Ock\Ock\Exception\GeneratorException_UnsupportedConfiguration;
use Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface;
use Ock\Ock\Formula\DrilldownVal\Formula_DrilldownValInterface;
use Ock\Ock\V2V\Drilldown\V2V_Drilldown_Trivial;
use Ock\Ock\V2V\Drilldown\V2V_DrilldownInterface;

class Generator_Drilldown implements GeneratorInterface {

  /**
   * @param \Ock\Ock\Formula\DrilldownVal\Formula_DrilldownValInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self
   */
  #[Adapter]
  public static function createFromDrilldownValFormula(
    #[Adaptee] Formula_DrilldownValInterface $formula,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
  ): self {
    return new self($formula->getDecorated(), $formula->getV2V(), $universalAdapter);
  }

  /**
   * @param \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self
   */
  #[Adapter]
  public static function createFromDrilldownFormula(
    #[Adaptee] Formula_DrilldownInterface $formula,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
  ): self {
    return new self($formula, new V2V_Drilldown_Trivial(), $universalAdapter);
  }

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface $formula
   * @param \Ock\Ock\V2V\Drilldown\V2V_DrilldownInterface $v2v
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   */
  protected function __construct(
    private readonly Formula_DrilldownInterface $formula,
    private readonly V2V_DrilldownInterface $v2v,
    private readonly UniversalAdapterInterface $universalAdapter,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {

    [$id, $subConf] = DrilldownKeysHelper::fromFormula($this->formula)
      ->unpack($conf);

    if (NULL === $id) {
      if ($this->formula->allowsNull()) {
        return 'NULL';
      }

      throw new GeneratorException_IncompatibleConfiguration(
        "Required id for drilldown is missing.");
    }

    $subValuePhp = $this->idConfGetSubValuePhp($id, $subConf);

    return $this->v2v->idPhpGetPhp($id, $subValuePhp);
  }

  /**
   * @param string|int $id
   * @param mixed $subConf
   *
   * @return string
   *
   * @throws \Ock\Ock\Exception\GeneratorException
   *   Configuration is incompatible or not supported.
   */
  private function idConfGetSubValuePhp(string|int $id, mixed $subConf): string {
    try {
      $subFormula = $this->formula->getIdToFormula()->idGetFormula($id);
    }
    catch (FormulaException $e) {
      throw new GeneratorException($e->getMessage(), 0, $e);
    }
    if ($subFormula === NULL) {
      throw new GeneratorException_IncompatibleConfiguration(
        "Unknown id '$id' in drilldown."
      );
    }
    try {
      $subGenerator = Generator::fromFormula($subFormula, $this->universalAdapter);
    }
    catch (AdapterException $e) {
      throw new GeneratorException_UnsupportedConfiguration(
        "Unsupported formula for id '$id' in drilldown.", 0, $e);
    }
    return $subGenerator->confGetPhp($subConf);
  }

}
