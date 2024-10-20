<?php

declare(strict_types=1);

namespace Ock\Ock\InlineDrilldown;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Id\Formula_IdInterface;
use Ock\Ock\Formula\Select\Flat\Formula_FlatSelectInterface;
use Ock\Ock\Formula\Select\Formula_Select_FromFlatSelect;
use Ock\Ock\Formula\Select\Formula_SelectInterface;
use Ock\Ock\Formula\ValueProvider\Formula_FixedPhp;

/**
 * @template-implements \Ock\Ock\InlineDrilldown\InlineDrilldownInterface<\Ock\Ock\Core\Formula\FormulaInterface>
 */
class InlineDrilldown_Select implements InlineDrilldownInterface {

  /**
   * @param \Ock\Ock\Formula\Select\Flat\Formula_FlatSelectInterface $formula
   *
   * @return self
   */
  #[Adapter]
  public static function createFlat(Formula_FlatSelectInterface $formula): self {
    return new self(
      new Formula_Select_FromFlatSelect($formula));
  }

  /**
   * @param \Ock\Ock\Formula\Select\Formula_SelectInterface $formula
   *
   * @return self
   */
  #[Adapter]
  public static function create(Formula_SelectInterface $formula): self {
    return new self($formula);
  }

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Select\Formula_SelectInterface $formula
   */
  public function __construct(
    private readonly Formula_SelectInterface $formula,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getIdFormula(): Formula_IdInterface {
    return $this->formula;
  }

  /**
   * {@inheritdoc}
   */
  public function idGetFormula(string|int $id): ?FormulaInterface {
    return Formula_FixedPhp::fromValueSimple($id);
  }

}
