<?php

declare(strict_types=1);

namespace Donquixote\Ock\Markup;

class Markup implements MarkupInterface {

  /**
   * Constructor.
   *
   * @param string $html
   */
  public function __construct(
    private readonly string $html,
  ) {}

  /**
   * @return string
   */
  public function __toString(): string {
    return $this->html;
  }

}
