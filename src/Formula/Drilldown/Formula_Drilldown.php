<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Drilldown;

use Donquixote\Ock\Formula\Id\Formula_IdInterface;
use Donquixote\Ock\Formula\Select\Formula_Select_FromOptions;
use Donquixote\Ock\IdToFormula\IdToFormula_FromOptions;
use Donquixote\Ock\IdToFormula\IdToFormulaInterface;

class Formula_Drilldown extends Formula_Drilldown_CustomKeysBase {

  /**
   * @param \Donquixote\Ock\Formula\Id\Formula_IdInterface $idFormula
   * @param \Donquixote\Ock\IdToFormula\IdToFormulaInterface $idToFormula
   * @param bool $orNull
   *
   * @return self
   */
  public static function create(Formula_IdInterface $idFormula, IdToFormulaInterface $idToFormula, bool $orNull = FALSE): self {
    return new self($idFormula, $idToFormula, $orNull);
  }

  /**
   * @param \Donquixote\Ock\Formula\Drilldown\Option\DrilldownOptionInterface[] $options
   * @param bool $orNull
   *
   * @return self
   */
  public static function fromOptions(array $options, bool $orNull = FALSE): self {
    return new self(
      new Formula_Select_FromOptions($options),
      new IdToFormula_FromOptions($options),
      $orNull);
  }

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Id\Formula_IdInterface $idFormula
   * @param \Donquixote\Ock\IdToFormula\IdToFormulaInterface $idToFormula
   * @param bool $orNull
   */
  public function __construct(
    private readonly Formula_IdInterface $idFormula,
    private readonly IdToFormulaInterface $idToFormula,
    bool $orNull = FALSE,
  ) {
    parent::__construct($orNull);
  }

  /**
   * {@inheritdoc}
   */
  public function getIdFormula(): Formula_IdInterface {
    return $this->idFormula;
  }

  /**
   * {@inheritdoc}
   */
  public function getIdToFormula(): IdToFormulaInterface {
    return $this->idToFormula;
  }

}
