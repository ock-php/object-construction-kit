<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests\Fixture\Plant;

use Donquixote\Ock\Attribute\Parameter\OckFormulaFromClass;
use Donquixote\Ock\Attribute\Parameter\OckOption;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Formula;
use Donquixote\Ock\Formula\Validator\Formula_ConstrainedValue_IntegerInRange;
use Donquixote\Ock\Text\Text_Translatable;

class Plant_OakTree implements PlantInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   * @throws \ReflectionException
   */
  public static function formula(): FormulaInterface {
    return Formula::group()
      ->add(
        'height',
        new Text_Translatable('Height in meters'),
        new Formula_ConstrainedValue_IntegerInRange(0, 100),
      )
      ->construct(self::class);
  }

  /**
   * @param int $height
   */
  public function __construct(
    #[OckOption('height', 'Height in meters')]
    #[OckFormulaFromClass(Formula_ConstrainedValue_IntegerInRange::class, [0, 100])]
    private readonly int $height,
  ) {}

  /**
   * @return int
   */
  public function getHeight(): int {
    return $this->height;
  }

}
