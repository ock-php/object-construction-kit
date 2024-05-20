<?php

declare(strict_types=1);

namespace Ock\Ock\Text;

class Text_ConcatDistinct extends Text_ListConcat {

  /**
   * {@inheritdoc}
   */
  protected function joinParts(array $parts): string {
    return parent::joinParts(array_unique($parts));
  }

}
