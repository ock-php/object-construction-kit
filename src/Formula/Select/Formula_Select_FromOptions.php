<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Select;

use Ock\Ock\Formula\Select\Option\SelectOptionInterface;
use Ock\Ock\Text\TextInterface;
use Ock\Ock\Translator\Translator;

class Formula_Select_FromOptions implements Formula_SelectInterface {

  /**
   * @var \Ock\Ock\Text\TextInterface[]|null
   */
  private ?array $groupLabels = NULL;

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Select\Option\SelectOptionInterface[] $options
   */
  public function __construct(
    private readonly array $options,
  ) {
    self::validateOptions(...$options);
  }

  /**
   * @param \Ock\Ock\Formula\Select\Option\SelectOptionInterface ...$options
   *
   * @psalm-suppress UnusedParam
   */
  private static function validateOptions(SelectOptionInterface ...$options): void {}

  /**
   * {@inheritdoc}
   */
  public function getOptionsMap(): array {
    // Use a simple translator to build group ids.
    $translator = Translator::passthru();
    $map = [];
    foreach ($this->options as $id => $option) {
      $map[$id] = $option->getGroupLabel()?->convert($translator) ?? '';
    }
    return $map;
  }

  /**
   * {@inheritdoc}
   */
  public function groupIdGetLabel(int|string $groupId): ?TextInterface {
    if ($this->groupLabels === NULL) {
      // Use a simple translator to build group ids.
      $translator = Translator::passthru();
      $this->groupLabels = [];
      foreach ($this->options as $option) {
        $groupLabel = $option->getGroupLabel();
        if ($groupLabel === NULL) {
          continue;
        }
        $this->groupLabels[$groupLabel->convert($translator)] = $groupLabel;
      }
    }
    return $this->groupLabels[$groupId] ?? NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function idGetLabel(string|int $id): ?TextInterface {
    return ($this->options[$id] ?? NULL)?->getLabel();
  }

  /**
   * {@inheritdoc}
   */
  public function idIsKnown(string|int $id): bool {
    return isset($this->options[$id]);
  }

}
