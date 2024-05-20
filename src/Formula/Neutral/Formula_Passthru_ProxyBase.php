<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Neutral;

use Ock\Ock\Core\Formula\FormulaInterface;

/**
 * A "proxy" formula can be created before the decorated formula exists.
 *
 * This allows e.g. recursive formulas.
 */
abstract class Formula_Passthru_ProxyBase implements Formula_PassthruInterface {

  /**
   * @var \Ock\Ock\Core\Formula\FormulaInterface
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
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  abstract protected function doGetDecorated(): FormulaInterface;

}
