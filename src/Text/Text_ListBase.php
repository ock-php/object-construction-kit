<?php

declare(strict_types=1);

namespace Ock\Ock\Text;

use Ock\Ock\Translator\TranslatorInterface;

abstract class Text_ListBase extends TextBase {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Text\TextInterface[] $items
   */
  public function __construct(
    private array $items,
  ) {
    Text::validate(...$items);
  }

  /**
   * @param \Ock\Ock\Text\TextInterface $item
   *
   * @return static
   */
  public function withAdded(TextInterface $item): static {
    $clone = clone $this;
    $clone->items[] = $item;
    return $clone;
  }

  /**
   * @param \Ock\Ock\Text\TextInterface $item
   *
   * @return $this
   */
  public function add(TextInterface $item): self {
    $this->items[] = $item;
    return $this;
  }

  /**
   * @param string $source
   *
   * @return $this
   */
  public function addT(string $source): self {
    $this->items[] = Text::t($source);
    return $this;
  }

  /**
   * @param string $source
   *
   * @return $this
   */
  public function addS(string $source): self {
    $this->items[] = Text::s($source);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function convert(TranslatorInterface $translator): string {
    $parts = [];
    foreach ($this->items as $item) {
      $part = $item->convert($translator);
      if ($part === '') {
        continue;
      }
      $parts[] = $part;
    }
    return $this->joinParts($parts);
  }

  /**
   * @param string[] $parts
   *
   * @return string
   */
  abstract protected function joinParts(array $parts): string;

}
