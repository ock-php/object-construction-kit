<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Drilldown;

use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Formula\Id\Formula_IdInterface;
use Ock\Ock\Formula\Select\Formula_Select_InlineExpanded;
use Ock\Ock\Formula\Select\Formula_SelectInterface;
use Ock\Ock\IdToFormula\IdToFormula_FilterDecorator;
use Ock\Ock\IdToFormula\IdToFormula_InlineExpanded;
use Ock\Ock\Util\UtilBase;

final class Formula_Drilldown_InlineExpanded extends UtilBase {

  /**
   * @param \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface $decorated
   * @param \Ock\Ock\Formula\Id\Formula_IdInterface $idIsInline
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Formula\Drilldown\Formula_DrilldownInterface|null
   */
  public static function create(Formula_DrilldownInterface $decorated, Formula_IdInterface $idIsInline, UniversalAdapterInterface $universalAdapter): ?Formula_DrilldownInterface {

    $decoratedIdFormula = $decorated->getIdFormula();

    if (!$decoratedIdFormula instanceof Formula_SelectInterface) {
      return NULL;
    }

    $idFormula = new Formula_Select_InlineExpanded(
      $decoratedIdFormula,
      new IdToFormula_FilterDecorator(
        $decorated->getIdToFormula(),
        $idIsInline),
      $universalAdapter);

    $idToFormula = new IdToFormula_InlineExpanded(
      $decorated->getIdToFormula(),
      $universalAdapter);

    return new Formula_Drilldown(
      $idFormula,
      $idToFormula);
  }

}
