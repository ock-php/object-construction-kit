<?php

declare(strict_types=1);

namespace Ock\Ock\Text;

class Text_ListConcat extends Text_ListBase {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Text\TextInterface[] $items
   * @param string $separator
   */
  public function __construct(
    array $items,
    private readonly string $separator = ', ',
  ) {
    parent::__construct($items);
  }

  /**
   * {@inheritdoc}
   */
  protected function joinParts(array $parts): string {
    return implode($this->separator, $parts);
  }

}
