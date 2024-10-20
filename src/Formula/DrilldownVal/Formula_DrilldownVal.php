<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\DrilldownVal;

use Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface;
use Ock\Ock\V2V\Drilldown\V2V_Drilldown_Arrify;
use Ock\Ock\V2V\Drilldown\V2V_Drilldown_Merge;
use Ock\Ock\V2V\Drilldown\V2V_DrilldownInterface;

class Formula_DrilldownVal implements Formula_DrilldownValInterface {

  /**
   * @param \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface $decorated
   * @param string|null $idKey
   * @param string|null $optionsKey
   *
   * @return self
   */
  public static function createArrify(Formula_DrilldownInterface $decorated, string $idKey = NULL, string $optionsKey = NULL): Formula_DrilldownVal {
    $v2v = new V2V_Drilldown_Arrify(
      $idKey ?? $decorated->getIdKey(),
      $optionsKey ?? $decorated->getOptionsKey(),
    );
    return new self($decorated, $v2v);
  }

  /**
   * @param \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface $decorated
   * @param string|null $idKey
   *
   * @return self
   */
  public static function createMerge(Formula_DrilldownInterface $decorated, string $idKey = NULL): Formula_DrilldownVal {

    if (NULL === $idKey) {
      $idKey = $decorated->getIdKey();
    }

    return new self(
      $decorated,
      new V2V_Drilldown_Merge($idKey));
  }

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface $decorated
   * @param \Ock\Ock\V2V\Drilldown\V2V_DrilldownInterface $v2v
   */
  public function __construct(
    private readonly Formula_DrilldownInterface $decorated,
    private readonly V2V_DrilldownInterface $v2v,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getV2V(): V2V_DrilldownInterface {
    return $this->v2v;
  }

  /**
   * {@inheritdoc}
   */
  public function getDecorated(): Formula_DrilldownInterface {
    return $this->decorated;
  }

}
