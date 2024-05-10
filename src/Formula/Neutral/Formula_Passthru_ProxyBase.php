<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Neutral;

use Donquixote\Ock\Core\Formula\FormulaInterface;

/**
 * A "proxy" formula can be created before the decorated formula exists.
 *
 * This allows e.g. recursive formulas.
 */
abstract class Formula_Passthru_ProxyBase implements Formula_PassthruInterface {

  /**
   * @var \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  private FormulaInterface $decorated;

  /**
   * {@inheritdoc}
   */
  public function getDecorated(): FormulaInterface {
    return $this->decorated
      ??= $this->doGetDecorated();
  }

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   */
  abstract protected function doGetDecorated(): FormulaInterface;

}
