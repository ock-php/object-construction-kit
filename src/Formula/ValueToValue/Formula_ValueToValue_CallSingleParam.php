<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\ValueToValue;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Util\UtilBase;
use Ock\Ock\V2V\Value\V2V_Value_CallSingleParam;

final class Formula_ValueToValue_CallSingleParam extends UtilBase {

  /**
   * @param string $class
   * @param string $methodName
   * @param \Ock\Ock\Core\Formula\FormulaInterface $decorated
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public static function fromStaticMethod(string $class, string $methodName, FormulaInterface $decorated): FormulaInterface {
    return self::fromFqn('\\' . $class . '::' . $methodName, $decorated);
  }

  /**
   * @param string $class
   * @param \Ock\Ock\Core\Formula\FormulaInterface $decorated
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public static function fromClass(string $class, FormulaInterface $decorated): FormulaInterface {
    return self::fromFqn('new \\' . $class, $decorated);
  }

  /**
   * @param string $fqn
   * @param \Ock\Ock\Core\Formula\FormulaInterface $decorated
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public static function fromFqn(string $fqn, FormulaInterface $decorated): FormulaInterface {
    return new Formula_ValueToValue(
      $decorated,
      new V2V_Value_CallSingleParam($fqn),
    );
  }

}
