<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Group;

use Ock\Ock\Exception\FormulaException;
use Ock\Ock\V2V\Group\V2V_Group_ExtraExpressions;
use Ock\Ock\V2V\Group\V2V_Group_Trivial;
use Ock\Ock\V2V\Group\V2V_GroupInterface;

class GroupValFormulaBuilder extends GroupValFormulaBuilderBase {

  /**
   * @var \Ock\Ock\V2V\Group\V2V_GroupInterface[]
   */
  private array $expressions = [];

  /**
   * Group items. Only here for collision detection.
   *
   * @var \Ock\Ock\Formula\Group\Item\GroupFormulaItemInterface[]
   */
  private array $items;

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Group\Formula_Group $groupFormula
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function __construct(
    private readonly Formula_Group $groupFormula,
  ) {
    $this->items = $groupFormula->getItems();
  }

  /**
   * {@inheritdoc}
   */
  protected function doAddExpression(string $key, V2V_GroupInterface $v2v): static {
    if (isset($this->items[$key]) || isset($this->expressions[$key])) {
      throw new FormulaException("Key '$key' already exists.");
    }
    $this->expressions[$key] = $v2v;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  protected function getGroupFormula(): Formula_Group {
    return $this->groupFormula;
  }

  /**
   * {@inheritdoc}
   */
  protected function decorateV2V(?V2V_GroupInterface $v2v): ?V2V_GroupInterface {
    if (!$this->expressions) {
      return null;
    }
    return new V2V_Group_ExtraExpressions(
      $v2v ?? new V2V_Group_Trivial(),
      $this->expressions,
    );
  }

}
