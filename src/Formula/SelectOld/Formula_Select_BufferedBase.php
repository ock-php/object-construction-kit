<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SelectOld;

use Donquixote\Ock\Text\Text;

abstract class Formula_Select_BufferedBase implements Formula_SelectInterface {

  /**
   * Buffered optgroups.
   *
   * @var \Donquixote\Ock\Text\TextInterface[]
   */
  private array $groups = [];

  /**
   * Buffered grouped options, with '' for top-level options.
   *
   * @var \Donquixote\Ock\Text\TextInterface[][]|null
   */
  private ?array $groupedOptions;

  /**
   * {@inheritdoc}
   */
  public function getOptGroups(): array {
    $this->init();
    return $this->groups;
  }

  /**
   * {@inheritdoc}
   */
  public function getOptions(?string $group_id): array {
    $this->init();
    return $this->groupedOptions[$group_id ?? ''] ?? [];
  }

  /**
   * Initializes buffered options and groups.
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   *   Failure to initialize the formula.
   */
  private function init(): void {
    if ($this->groupedOptions !== NULL) {
      return;
    }
    $this->groupedOptions = ['' => []];
    $this->initialize($this->groupedOptions, $this->groups);
    $this->groupedOptions = array_filter($this->groupedOptions);
    Text::validateNested($this->groupedOptions);
    Text::validateMultiple($this->groups);
  }

  /**
   * Initializes grouped options and optgroup labels.
   *
   * @param \Donquixote\Ock\Text\TextInterface[][] $grouped_options
   *   Format: $[$group_id][$id] = $label,
   *   with $group_id === '' for top-level options.
   * @param \Donquixote\Ock\Text\TextInterface[] $group_labels
   *   Format: $[$optgroup_id] = $optgroup_label.
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   *   Failure to initialize the formula.
   */
  abstract protected function initialize(array &$grouped_options, array &$group_labels): void;

}
