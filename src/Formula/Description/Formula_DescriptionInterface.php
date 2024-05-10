<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Description;

use Donquixote\Ock\Text\TextInterface;

interface Formula_DescriptionInterface {

  /**
   * @return \Donquixote\Ock\Text\TextInterface|null
   */
  public function getDescription(): ?TextInterface;

}
