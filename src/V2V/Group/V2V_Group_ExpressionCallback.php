<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Group;

class V2V_Group_ExpressionCallback implements V2V_GroupInterface {

  /**
   * Constructor.
   *
   * @param callable(string[], mixed[]): string $expressionCallback
   */
  public function __construct(
    private readonly mixed $expressionCallback,
  ) {}

  /**
   * {@inheritdoc}
   * @param array $conf
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
    return ($this->expressionCallback)($itemsPhp, $conf);
  }

}
