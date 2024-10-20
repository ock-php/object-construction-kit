<?php

declare(strict_types=1);

namespace Ock\Ock\InlineDrilldown;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface;
use Ock\Ock\Formula\DrilldownVal\Formula_DrilldownValInterface;
use Ock\Ock\Formula\Formula;
use Ock\Ock\Formula\Id\Formula_IdInterface;
use Ock\Ock\Formula\Select\Formula_SelectInterface;
use Ock\Ock\Formula\ValueToValue\Formula_ValueToValue;
use Ock\Ock\V2V\Drilldown\V2V_Drilldown_Trivial;
use Ock\Ock\V2V\Drilldown\V2V_DrilldownInterface;
use Ock\Ock\V2V\Value\V2V_Value_DrilldownFixedId;

class InlineDrilldown_Drilldown implements InlineDrilldownInterface {

  /**
   * @param \Ock\Ock\Formula\DrilldownVal\Formula_DrilldownValInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
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
   * @param \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
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
   * @param \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface $formula
   * @param \Ock\Ock\V2V\Drilldown\V2V_DrilldownInterface $v2v
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
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
   * @param \Ock\Ock\Formula\Select\Formula_SelectInterface $idFormula
   * @param \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface $formula
   * @param \Ock\Ock\V2V\Drilldown\V2V_DrilldownInterface $v2v
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
    $formula = new Formula_ValueToValue(
      $formula,
      new V2V_Value_DrilldownFixedId($this->v2v, $id),
    );
    return $formula;
  }

}
