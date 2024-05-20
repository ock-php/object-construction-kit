<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Boolean;

use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\DefaultConf\Formula_DefaultConf;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

class Formula_Boolean_YesNo implements Formula_BooleanInterface {

  /**
   * @param bool $enabledByDefault
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
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
