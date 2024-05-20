<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Cache;

interface Formula_CacheBaseInterface {

  /**
   * @return string
   */
  public function getCacheId(): string;

}
