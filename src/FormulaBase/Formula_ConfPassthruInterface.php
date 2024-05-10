<?php

declare(strict_types=1);

namespace Donquixote\Ock\FormulaBase;

use Donquixote\Ock\Core\Formula\FormulaInterface;

/**
 * Base interface for decorators that don't affect config form and summary.
 *
 * @see \Donquixote\Ock\Form\Common\FormatorCommon_V2V
 * @see \Donquixote\Ock\Summarizer\Summarizer_V2V
 */
interface Formula_ConfPassthruInterface extends FormulaInterface {

  /**
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public function getDecorated(): FormulaInterface;

}
