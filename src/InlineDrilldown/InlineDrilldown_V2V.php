<?php

declare(strict_types=1);

namespace Ock\Ock\InlineDrilldown;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Id\Formula_IdInterface;
use Ock\Ock\Formula\ValueToValue\Formula_ValueToValue;
use Ock\Ock\V2V\Value\V2V_ValueInterface;

/**
 * @template T of \Ock\Ock\Core\Formula\FormulaInterface
 *
 * @template-implements \Ock\Ock\InlineDrilldown\InlineDrilldownInterface<T>
 */
class InlineDrilldown_V2V implements InlineDrilldownInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\InlineDrilldown\InlineDrilldownInterface<T> $decorated
   * @param \Ock\Ock\V2V\Value\V2V_ValueInterface $v2v
   */
  public function __construct(
    private readonly InlineDrilldownInterface $decorated,
    private readonly V2V_ValueInterface $v2v,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getIdFormula(): Formula_IdInterface {
    return $this->decorated->getIdFormula();
  }

  /**
   * {@inheritdoc}
   */
  public function idGetFormula(string|int $id): ?FormulaInterface {
    $formula = $this->decorated->idGetFormula($id);
    if ($formula === NULL) {
      return NULL;
    }
    return new Formula_ValueToValue($formula, $this->v2v);
  }

}
