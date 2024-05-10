<?php

declare(strict_types=1);

namespace Donquixote\Ock\TextLookup;

use Donquixote\Ock\Text\TextInterface;

/**
 * Helper object to provide labels in bulk.
 *
 * It is recommended to call this indirectly via LabelLookup::*().
 */
interface TextLookupInterface {

  /**
   * @param string|int $id
   *
   * @return \Donquixote\Ock\Text\TextInterface|null
   */
  public function idGetText(string|int $id): ?TextInterface;

}
