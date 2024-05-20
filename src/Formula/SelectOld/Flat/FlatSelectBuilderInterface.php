<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\SelectOld\Flat;

use Ock\Ock\Text\TextInterface;

interface FlatSelectBuilderInterface {

  /**
   * Adds a select option.
   *
   * @param string $name
   * @param \Ock\Ock\Text\TextInterface $label
   *
   * @return $this
   */
  public function add(string $name, TextInterface $label): self;

  /**
   * Builds the formula.
   *
   * @return \Ock\Ock\Formula\SelectOld\Flat\Formula_FlatSelectInterface
   */
  public function create(): Formula_FlatSelectInterface;

}
