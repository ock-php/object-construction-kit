<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\SelectOld\Option;

use Donquixote\Ock\Text\TextInterface;

interface SelectOptionInterface {

  /**
   * @return \Donquixote\Ock\Text\TextInterface|null
   */
  public function getLabel(): ?TextInterface;

  /**
   * @return \Donquixote\Ock\Text\TextInterface|null
   */
  public function getGroupLabel(): ?TextInterface;

}
