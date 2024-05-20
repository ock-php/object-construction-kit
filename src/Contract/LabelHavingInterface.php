<?php

declare(strict_types=1);

namespace Ock\Ock\Contract;

use Ock\Ock\Text\TextInterface;

/**
 * Generic interface for objects that provide a label.
 */
interface LabelHavingInterface {

  /**
   * @return \Ock\Ock\Text\TextInterface
   */
  public function getLabel(): TextInterface;

}
