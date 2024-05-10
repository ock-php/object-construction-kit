<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\DefaultConf;

use Donquixote\Ock\Core\Formula\FormulaInterface;

class Formula_DefaultConf implements Formula_DefaultConfInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $decorated
   * @param mixed $defaultConf
   */
  public function __construct(
    private readonly FormulaInterface $decorated,
    private readonly mixed $defaultConf,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getDecorated(): FormulaInterface {
    return $this->decorated;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultConf(): mixed {
    return $this->defaultConf;
  }

}
