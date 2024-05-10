<?php

declare(strict_types=1);

namespace Donquixote\Ock\Optionlessness;

use Donquixote\Ock\Core\Formula\Base\FormulaBaseInterface;
use Donquixote\Ock\Form\Common\FormatorCommonInterface;

interface OptionlessnessInterface extends FormatorCommonInterface, FormulaBaseInterface {

  /**
   * @return bool
   */
  public function isOptionless(): bool;

}
