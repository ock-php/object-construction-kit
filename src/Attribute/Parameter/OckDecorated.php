<?php

declare(strict_types=1);

namespace Donquixote\Ock\Attribute\Parameter;

use Donquixote\Ock\Contract\FormulaHavingInterface;
use Donquixote\Ock\Contract\LabelHavingInterface;
use Donquixote\Ock\Contract\NameHavingInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\ValueProvider\Formula_FixedPhp_Decorated;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class OckDecorated implements NameHavingInterface, LabelHavingInterface, FormulaHavingInterface {

  /**
   * {@inheritdoc}
   */
  public function getLabel(): TextInterface {
    return Text::t('Decorated');
  }

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'decorated';
  }

  /**
   * {@inheritdoc}
   */
  public function getFormula(): FormulaInterface {
    return new Formula_FixedPhp_Decorated();
  }

}
