<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Fixture\Plant;

use Ock\Ock\Attribute\Parameter\OckFormulaFromClass;
use Ock\Ock\Attribute\Parameter\OckOption;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Formula;
use Ock\Ock\Formula\Validator\Formula_ConstrainedValue_IntegerInRange;
use Ock\Ock\Text\Text_Translatable;

class Plant_OakTree implements PlantInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Ock\Ock\Exception\FormulaException
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
