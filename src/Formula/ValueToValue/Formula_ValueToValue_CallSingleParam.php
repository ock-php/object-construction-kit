<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\ValueToValue;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Util\UtilBase;
use Donquixote\Ock\V2V\Value\V2V_Value_CallSingleParam;

final class Formula_ValueToValue_CallSingleParam extends UtilBase {

  /**
   * @param string $class
   * @param string $methodName
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $decorated
   *
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public static function fromStaticMethod(string $class, string $methodName, FormulaInterface $decorated): FormulaInterface {
    return self::fromFqn('\\' . $class . '::' . $methodName, $decorated);
  }

  /**
   * @param string $class
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $decorated
   *
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public static function fromClass(string $class, FormulaInterface $decorated): FormulaInterface {
    return self::fromFqn('new \\' . $class, $decorated);
  }

  /**
   * @param string $fqn
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $decorated
   *
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public static function fromFqn(string $fqn, FormulaInterface $decorated): FormulaInterface {
    return new Formula_ValueToValue(
      $decorated,
      new V2V_Value_CallSingleParam($fqn),
    );
  }

}
