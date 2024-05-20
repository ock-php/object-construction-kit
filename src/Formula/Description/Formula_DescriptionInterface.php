<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Description;

use Ock\Ock\Text\TextInterface;

interface Formula_DescriptionInterface {

  /**
   * @return \Ock\Ock\Text\TextInterface|null
   */
  public function getDescription(): ?TextInterface;

}
