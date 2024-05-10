<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SelectOld\Flat;

use Donquixote\Ock\Text\TextInterface;

interface FlatSelectBuilderInterface {

  /**
   * Adds a select option.
   *
   * @param string $name
   * @param \Donquixote\Ock\Text\TextInterface $label
   *
   * @return $this
   */
  public function add(string $name, TextInterface $label): self;

  /**
   * Builds the formula.
   *
   * @return \Donquixote\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface
   */
  public function create(): Formula_FlatSelectInterface;

}
