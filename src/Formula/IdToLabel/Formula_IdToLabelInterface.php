<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\IdToLabel;

use Ock\Ock\Formula\Id\Formula_IdInterface;
use Ock\Ock\Text\TextInterface;

interface Formula_IdToLabelInterface extends Formula_IdInterface {

  /**
   * Gets the option label for a given id.
   *
   * @param string|int $id
   *   The id.
   *
   * @return \Ock\Ock\Text\TextInterface|null
   *   The label as a string or stringable object.
   *
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function idGetLabel(string|int $id): ?TextInterface;

}
