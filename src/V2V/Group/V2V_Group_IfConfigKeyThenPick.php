<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\Group;

class V2V_Group_IfConfigKeyThenPick implements V2V_GroupInterface {

  /**
   * Constructor.
   *
   * @param string $conditionConfigKey
   * @param string $ifTrueKey
   * @param string $ifFalseKey
   */
  public function __construct(
    private readonly string $conditionConfigKey,
    private readonly string $ifTrueKey,
    private readonly string $ifFalseKey,
  ) {}

  /**
   * {@inheritdoc}
   * @param array $conf
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
    if ($conf[$this->conditionConfigKey] ?? FALSE) {
      return $itemsPhp[$this->ifTrueKey];
    }
    return $itemsPhp[$this->ifFalseKey];
  }

}
