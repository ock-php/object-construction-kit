<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Fixture\IntOp;

use Ock\Ock\Attribute\Plugin\OckPluginFormula;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Formula;
use Ock\Ock\Text\Text;

class IntOp_Sequence implements IntOpInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  #[OckPluginFormula(self::class, "sequence", "Sequence")]
  public static function formula(): FormulaInterface {
    return Formula::group()
      ->add(
        'operations',
        Text::t('Operations'),
        Formula::ifaceSequence(IntOpInterface::class))
      ->construct(self::class);
  }

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Tests\Fixture\IntOp\IntOpInterface[] $operations
   */
  public function __construct(
    private readonly array $operations,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function transform(int $number): int {
    foreach ($this->operations as $operation) {
      $number = $operation->transform($number);
    }
    return $number;
  }

}
