<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Group;

use Donquixote\Ock\Exception\FormulaException;
use Donquixote\Ock\V2V\Group\V2V_Group_ExtraExpressions;
use Donquixote\Ock\V2V\Group\V2V_Group_Trivial;
use Donquixote\Ock\V2V\Group\V2V_GroupInterface;

class GroupValFormulaBuilder extends GroupValFormulaBuilderBase {

  /**
   * @var \Donquixote\Ock\V2V\Group\V2V_GroupInterface[]
   */
  private array $expressions = [];

  /**
   * Group items. Only here for collision detection.
   *
   * @var \Donquixote\Ock\Formula\Group\Item\GroupFormulaItemInterface[]
   */
  private array $items;

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Group\Formula_Group $groupFormula
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
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
