<?php

declare(strict_types=1);

namespace Ock\Ock\Optionlessness;

use Ock\Ock\Core\Formula\Base\FormulaBaseInterface;
use Ock\Ock\Form\Common\FormatorCommonInterface;

interface OptionlessnessInterface extends FormatorCommonInterface, FormulaBaseInterface {

  /**
   * @return bool
   */
  public function isOptionless(): bool;

}
