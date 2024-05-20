<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Fixture\IntCondition;

use Ock\Ock\Attribute\Plugin\OckPluginFormula;
use Ock\Ock\Attribute\Plugin\OckPluginInstance;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Formula;
use Ock\Ock\Formula\Primitive\Formula_Int;
use Ock\Ock\Text\Text;

/**
 * Compares the number to a defined operand.
 */
class IntCondition_GreaterThan implements IntConditionInterface {

  /**
   * Constructor.
   *
   * @param int $operand
   */
  public function __construct(
    private readonly int $operand,
  ) {}

  /**
   * @return self
   */
  #[OckPluginInstance('positive', 'Number is positive')]
  public static function positive(): self {
    return new self(0);
  }

  /**
   * @return self
   */
  #[OckPluginInstance('not_negative', 'Number is not negative')]
  public static function notNegative(): self {
    return new self(-1);
  }

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  #[OckPluginFormula(self::class, 'greater_than', 'Greater than')]
  public static function formula(): FormulaInterface {
    return Formula::group()
      ->add('operand', Text::t('Operand'), new Formula_Int())
      ->construct(self::class);
  }

  /**
   * {@inheritdoc}
   */
  public function check(int $number): bool {
    return $number > $this->operand;
  }

}
