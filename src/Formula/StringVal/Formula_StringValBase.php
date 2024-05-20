<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\StringVal;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\Textfield\Formula_TextfieldInterface;

abstract class Formula_StringValBase implements Formula_StringValInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Textfield\Formula_TextfieldInterface $decorated
   */
  public function __construct(
    private readonly Formula_TextfieldInterface $decorated,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getDecorated(): FormulaInterface {
    return $this->decorated;
  }

}
