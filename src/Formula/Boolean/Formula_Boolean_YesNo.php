<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Boolean;

use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\DefaultConf\Formula_DefaultConf;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

class Formula_Boolean_YesNo implements Formula_BooleanInterface {

  /**
   * @param bool $enabledByDefault
   *
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   */
  public static function create(bool $enabledByDefault = FALSE): FormulaInterface {

    if ($enabledByDefault) {
      return new Formula_DefaultConf(new self(), TRUE);
    }

    return new self();
  }

  /**
   * {@inheritdoc}
   */
  public function getTrueSummary(): ?TextInterface {
    return Text::t('Yes');
  }

  /**
   * {@inheritdoc}
   */
  public function getFalseSummary(): ?TextInterface {
    return Text::t('No');
  }

}
