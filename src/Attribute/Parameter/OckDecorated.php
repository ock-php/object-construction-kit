<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\Parameter;

use Ock\Ock\Contract\FormulaHavingInterface;
use Ock\Ock\Contract\LabelHavingInterface;
use Ock\Ock\Contract\NameHavingInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\ValueProvider\Formula_FixedPhp_Decorated;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

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
