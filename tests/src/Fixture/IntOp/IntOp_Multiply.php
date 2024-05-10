<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests\Fixture\IntOp;

use Donquixote\Ock\Attribute\Plugin\OckPluginFormula;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Formula;
use Donquixote\Ock\Formula\Primitive\Formula_Int;
use Donquixote\Ock\Text\Text;

class IntOp_Multiply implements IntOpInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
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
