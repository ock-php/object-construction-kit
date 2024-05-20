<?php

declare(strict_types=1);

namespace Ock\Ock\FormulaBase\Decorator;

use Ock\Ock\Core\Formula\FormulaInterface;

class Formula_DecoratorBase implements FormulaInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $decorated
   */
  public function __construct(
    private readonly FormulaInterface $decorated,
  ) {}

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *   The non-optional version.
   */
  public function getDecorated(): FormulaInterface {
    return $this->decorated;
  }

}
