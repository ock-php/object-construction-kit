<?php

declare(strict_types=1);

namespace Donquixote\Ock\Contract;

/**
 * Generic interface for objects that provide a machine name / key.
 */
interface NameHavingInterface {

  /**
   * @return string
   */
  public function getName(): string;

}
