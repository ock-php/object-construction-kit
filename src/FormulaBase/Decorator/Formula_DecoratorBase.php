<?php

declare(strict_types=1);

namespace Donquixote\Ock\FormulaBase\Decorator;

use Donquixote\Ock\Core\Formula\FormulaInterface;

class Formula_DecoratorBase implements FormulaInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $decorated
   */
  public function __construct(
    private readonly FormulaInterface $decorated,
  ) {}

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   *   The non-optional version.
   */
  public function getDecorated(): FormulaInterface {
    return $this->decorated;
  }

}
