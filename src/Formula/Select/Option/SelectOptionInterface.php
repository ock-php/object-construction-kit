<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Select\Option;

use Ock\Ock\Text\TextInterface;

interface SelectOptionInterface {

  /**
   * @return \Ock\Ock\Text\TextInterface|null
   */
  public function getLabel(): ?TextInterface;

  /**
   * @return \Ock\Ock\Text\TextInterface|null
   */
  public function getGroupLabel(): ?TextInterface;

}
