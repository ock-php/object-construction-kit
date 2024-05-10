<?php

declare(strict_types=1);

namespace Donquixote\Ock\InlineDrilldown;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Id\Formula_IdInterface;
use Donquixote\Ock\Formula\Select\Flat\Formula_FlatSelectInterface;
use Donquixote\Ock\Formula\Select\Formula_Select_FromFlatSelect;
use Donquixote\Ock\Formula\Select\Formula_SelectInterface;
use Donquixote\Ock\Formula\ValueProvider\Formula_FixedPhp;

class InlineDrilldown_Select implements InlineDrilldownInterface {

  /**
   * @param \Donquixote\Ock\Formula\Select\Flat\Formula_FlatSelectInterface $formula
   *
   * @return self
   */
  #[Adapter]
  public static function createFlat(Formula_FlatSelectInterface $formula): self {
    return new self(
      new Formula_Select_FromFlatSelect($formula));
  }

  /**
   * @param \Donquixote\Ock\Formula\Select\Formula_SelectInterface $formula
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
   * @param \Donquixote\Ock\Formula\Select\Formula_SelectInterface $formula
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
