<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Group\Item;

use Donquixote\CodegenTools\Util\MessageUtil;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Exception\FormulaException;
use Donquixote\Ock\Text\TextInterface;

class GroupFormulaItem_Callback implements GroupFormulaItemInterface {

  /**
   * @var callable
   */
  private readonly mixed $labelOrCallback;

  /**
   * @var callable
   */
  private readonly mixed $formulaCallback;

  /**
   * Constructor.
   *
   * @param string[] $dependsOnKeys
   * @param (callable(): TextInterface)|TextInterface $labelOrCallback
   * @param callable(): FormulaInterface $formulaCallback
   */
  public function __construct(
    private readonly array $dependsOnKeys,
    callable|TextInterface $labelOrCallback,
    callable $formulaCallback,
  ) {
    $this->labelOrCallback = $labelOrCallback;
    $this->formulaCallback = $formulaCallback;
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel(array $args = []): TextInterface {
    return ($this->labelOrCallback instanceof TextInterface)
      ? $this->labelOrCallback
      : ($this->labelOrCallback)(...$args);
  }

  /**
   * {@inheritdoc}
   */
  public function dependsOnKeys(): array {
    return $this->dependsOnKeys;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormula(array $args = []): FormulaInterface {
    try {
      $formula = ($this->formulaCallback)(...$args);
    }
    catch (\Throwable $e) {
      throw new FormulaException(sprintf(
        'Failing formula callback: %s: %s.',
        MessageUtil::formatValue($this->formulaCallback),
        $e->getMessage(),
      ), 0, $e);
    }
    if (!$formula instanceof FormulaInterface) {
      throw new FormulaException(sprintf(
        'Unexpected return value %s from formula callback %s.',
        MessageUtil::formatValue($formula),
        MessageUtil::formatValue($this->formulaCallback),
      ));
    }
    return $formula;
  }

}
