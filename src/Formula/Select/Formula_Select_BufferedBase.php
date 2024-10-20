<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Select;

use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

abstract class Formula_Select_BufferedBase implements Formula_SelectInterface {

  /**
   * Buffered option map.
   *
   * @var array<string, string>
   */
  private ?array $map = NULL;

  /**
   * Buffered labels.
   *
   * @var \Ock\Ock\Text\TextInterface[]
   */
  private array $labels = [];

  /**
   * Buffered group labels.
   *
   * @var \Ock\Ock\Text\TextInterface[]
   */
  private array $groupLabels = [];

  /**
   * Initializes buffered options and groups.
   *
   * @throws \Ock\Ock\Exception\FormulaException
   *   Failure to initialize the formula.
   */
  private function init(): void {
    if ($this->map !== NULL) {
      return;
    }
    // Use local variables, instead of writing directly to object properties.
    // This is easier to follow for static analysis (PhpStan).
    $map = [];
    $labels = [];
    $group_labels = [];
    $this->initialize($map, $labels, $group_labels);
    // Validate.
    (static fn (string ...$args) => null)(...$map);
    (static fn (TextInterface ...$args) => null)(...$labels);
    (static fn (TextInterface ...$args) => null)(...$group_labels);
    $this->map = $map;
    $this->labels = $labels;
    $this->groupLabels = $group_labels;
  }

  /**
   * Initializes grouped options and optgroup labels.
   *
   * @param array<string, string> $map
   *   Format: $[$id] = $groupId,
   *   with $group_id === '' for top-level options.
   * @param \Ock\Ock\Text\TextInterface[] $labels
   *   Format: $[$id] = $label.
   * @param \Ock\Ock\Text\TextInterface[] $groupLabels
   *   Format: $[$optgroup_id] = $optgroup_label.
   *
   * @throws \Ock\Ock\Exception\FormulaException
   *   Failure to initialize the formula.
   */
  abstract protected function initialize(array &$map, array &$labels, array &$groupLabels): void;

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(int|string $id): bool {
    $this->init();
    return isset($this->map[$id]);
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(int|string $id): ?TextInterface {
    $this->init();
    if (!isset($this->map[$id])) {
      return NULL;
    }
    return $this->labels[$id] ?? Text::s((string) $id);
  }

  /**
   * {@inheritdoc}
   */
  public function getOptionsMap(): array {
    $this->init();
    // @todo Would be nice to declare this post-condition on init() itself.
    assert($this->map !== null);
    return $this->map;
  }

  /**
   * {@inheritdoc}
   */
  public function groupIdGetLabel(int|string $groupId): ?TextInterface {
    return $this->groupLabels[$groupId] ?? NULL;
  }

}
