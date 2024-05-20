<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Fixture\IntOp;

use Ock\Ock\Attribute\Plugin\OckPluginFormula;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Formula;
use Ock\Ock\Formula\Primitive\Formula_Int;
use Ock\Ock\Text\Text;

class IntOp_Multiply implements IntOpInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Ock\Ock\Exception\FormulaException
   * @throws \ReflectionException
   */
  #[OckPluginFormula(self::class, "multiply", "Multiply")]
  public static function formula(): FormulaInterface {
    return Formula::group()
      ->add('factor', Text::t('Factor'), new Formula_Int())
      ->construct(self::class);
  }

  /**
   * Constructor.
   *
   * @param int $factor
   */
  public function __construct(
    private readonly int $factor,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function transform(int $number): int {
    return $number * $this->factor;
  }

}
