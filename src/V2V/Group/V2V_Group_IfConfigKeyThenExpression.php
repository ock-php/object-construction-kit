<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Group;

class V2V_Group_IfConfigKeyThenExpression implements V2V_GroupInterface {

  /**
   * Constructor.
   *
   * @param string $conditionConfigKey
   * @param \Ock\Ock\V2V\Group\V2V_GroupInterface $expressionIfTrue
   * @param \Ock\Ock\V2V\Group\V2V_GroupInterface $expressionIfFalse
   */
  public function __construct(
    private readonly string $conditionConfigKey,
    private readonly V2V_GroupInterface $expressionIfTrue,
    private readonly V2V_GroupInterface $expressionIfFalse,
  ) {}

  /**
   * {@inheritdoc}
   * @param array $conf
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
    if ($conf[$this->conditionConfigKey]) {
      return $this->expressionIfTrue->itemsPhpGetPhp($itemsPhp, $conf);
    }
    return $this->expressionIfFalse->itemsPhpGetPhp($itemsPhp, $conf);
  }

}
