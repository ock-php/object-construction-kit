<?php

declare(strict_types=1);

namespace Donquixote\Ock\InlineDrilldown;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Drilldown\Formula_DrilldownInterface;
use Donquixote\Ock\Formula\DrilldownVal\Formula_DrilldownValInterface;
use Donquixote\Ock\Formula\Formula;
use Donquixote\Ock\Formula\Id\Formula_IdInterface;
use Donquixote\Ock\Formula\Select\Formula_SelectInterface;
use Donquixote\Ock\Formula\ValueToValue\Formula_ValueToValue;
use Donquixote\Ock\V2V\Drilldown\V2V_Drilldown_Trivial;
use Donquixote\Ock\V2V\Drilldown\V2V_DrilldownInterface;
use Donquixote\Ock\V2V\Value\V2V_Value_DrilldownFixedId;

class InlineDrilldown_Drilldown implements InlineDrilldownInterface {

  /**
   * @param \Donquixote\Ock\Formula\DrilldownVal\Formula_DrilldownValInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self|null
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function fromDrilldownVal(
    Formula_DrilldownValInterface $formula,
    UniversalAdapterInterface $universalAdapter
  ): ?self {
    return self::create(
      $formula->getDecorated(),
      $formula->getV2V(),
      $universalAdapter);
  }

  /**
   * @param \Donquixote\Ock\Formula\Drilldown\Formula_DrilldownInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self|null
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function fromDrilldown(
    Formula_DrilldownInterface $formula,
    UniversalAdapterInterface $universalAdapter
  ): ?self {
    return self::create(
      $formula,
      new V2V_Drilldown_Trivial(),
      $universalAdapter);
  }

  /**
   * @param \Donquixote\Ock\Formula\Drilldown\Formula_DrilldownInterface $formula
   * @param \Donquixote\Ock\V2V\Drilldown\V2V_DrilldownInterface $v2v
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self|null
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  public static function create(
    Formula_DrilldownInterface $formula,
    V2V_DrilldownInterface $v2v,
    UniversalAdapterInterface $universalAdapter
  ): ?self {
    $idFormula = Formula::replace(
      $formula->getIdFormula(),
      $universalAdapter);
    if (!$idFormula instanceof Formula_SelectInterface) {
      return NULL;
    }
    return new self(
      $idFormula,
      $formula,
      $v2v);
  }

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Select\Formula_SelectInterface $idFormula
   * @param \Donquixote\Ock\Formula\Drilldown\Formula_DrilldownInterface $formula
   * @param \Donquixote\Ock\V2V\Drilldown\V2V_DrilldownInterface $v2v
   */
  public function __construct(
    private readonly Formula_SelectInterface $idFormula,
    private readonly Formula_DrilldownInterface $formula,
    private readonly V2V_DrilldownInterface $v2v
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getIdFormula(): Formula_IdInterface {
    return $this->idFormula;
  }

  /**
   * {@inheritdoc}
   */
  public function idGetFormula(string|int $id): ?FormulaInterface {
    $formula = $this->formula->getIdToFormula()->idGetFormula($id);
    if ($formula === NULL) {
      return NULL;
    }
    if ($this->v2v) {
      $formula = new Formula_ValueToValue(
        $formula,
        new V2V_Value_DrilldownFixedId($this->v2v, $id));
    }
    return $formula;
  }

}
