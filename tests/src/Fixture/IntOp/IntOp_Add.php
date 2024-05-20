<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Fixture\IntOp;

use Ock\Ock\Attribute\Plugin\OckPluginFormula;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Formula;
use Ock\Ock\Formula\Primitive\Formula_Int;
use Ock\Ock\Text\Text;

class IntOp_Add implements IntOpInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  #[OckPluginFormula(self::class, "add", "Add")]
  public static function formula(): FormulaInterface {
    return Formula::group()
      ->add('increment', Text::t('Increment'), new Formula_Int())
      ->construct(self::class);
  }

  /**
   * Constructor.
   *
   * @param int $increment
   */
  public function __construct(private readonly int $increment) {
  }

  /**
   * {@inheritdoc}
   */
  public function transform(int $number): int {
    return $number + $this->increment;
  }

}
