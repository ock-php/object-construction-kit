<?php

declare(strict_types=1);

namespace Donquixote\Ock\TextLookupMap;

use Donquixote\Ock\TextLookup\TextLookupInterface;

interface TextLookupMapInterface {

  /**
   * Gets a text lookup map specified by an id.
   *
   * @param string $id
   *
   * @return \Donquixote\Ock\TextLookup\TextLookupInterface|null
   */
  public function idGetTextLookup(string $id): ?TextLookupInterface;

}
