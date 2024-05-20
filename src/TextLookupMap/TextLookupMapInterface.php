<?php

declare(strict_types=1);

namespace Ock\Ock\TextLookupMap;

use Ock\Ock\TextLookup\TextLookupInterface;

interface TextLookupMapInterface {

  /**
   * Gets a text lookup map specified by an id.
   *
   * @param string $id
   *
   * @return \Ock\Ock\TextLookup\TextLookupInterface|null
   */
  public function idGetTextLookup(string $id): ?TextLookupInterface;

}
