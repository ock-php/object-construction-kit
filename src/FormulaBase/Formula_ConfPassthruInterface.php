<?php

declare(strict_types=1);

namespace Ock\Ock\FormulaBase;

use Ock\Ock\Core\Formula\FormulaInterface;

/**
 * Base interface for decorators that don't affect config form and summary.
 *
 * @see \Ock\Ock\Form\Common\FormatorCommon_V2V
 * @see \Ock\Ock\Summarizer\Summarizer_V2V
 */
interface Formula_ConfPassthruInterface extends FormulaInterface {

  /**
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

}
