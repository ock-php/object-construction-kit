<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\SelectOld;

use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

/**
 * @phpstan-ignore class.implementsDeprecatedInterface
 */
class Formula_Select_Fixed implements Formula_SelectInterface {

  /**
   * Flattened options.
   *
   * @var \Ock\Ock\Text\TextInterface[]
   */
  private array $flatOptions;

  /**
   * @param \Ock\Ock\Text\TextInterface[] $options
   *
   * @return self
   */
  public static function createFlat(array $options): self {
    return new self(['' => $options]);
  }

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Text\TextInterface[][] $groupedOptions
   *   Format: $[$group_id][$option_value] = $option_label,
   *   with $group_id === '' for top-level options.
   * @param \Ock\Ock\Text\TextInterface[] $groups
   *   Optgroup labels, without the top-level group.
   */
  public function __construct(
    private array $groupedOptions,
    private array $groups = [],
  ) {
    $this->flatOptions = $groupedOptions
      ? array_replace(...array_values($groupedOptions))
      : [];
  }

  /**
   * @param string $id
   * @param \Ock\Ock\Text\TextInterface $label
   * @param string $group_id
   * @param \Ock\Ock\Text\TextInterface|null $group_label
   *
   * @return static
   */
  public function withOption(string $id, TextInterface $label, string $group_id = '', TextInterface $group_label = NULL): static {
    $clone = clone $this;
    $clone->groupedOptions[$group_id][$id] = $label;
    $clone->flatOptions[$id] = $label;
    if ($group_id !== '') {
      $clone->groups[$group_id] = $group_label ?? Text::s($group_id);
    }
    return $clone;
  }

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(string|int $id): bool {
    return isset($this->flatOptions[$id]);
  }

  /**
   * {@inheritdoc}
   */
  public function getOptGroups(): array {
    return $this->groups;
  }

  /**
   * {@inheritdoc}
   */
  public function getOptions(?string $group_id): array {
    return $this->groupedOptions[$group_id ?? ''] ?? [];
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {
    return $this->flatOptions[$id] ?? NULL;
  }

}
