<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests\Fixture\IntOp;

use Donquixote\Ock\Attribute\Plugin\OckPluginFormula;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Formula;
use Donquixote\Ock\Formula\Primitive\Formula_Int;
use Donquixote\Ock\Text\Text;

class IntOp_Add implements IntOpInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
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
