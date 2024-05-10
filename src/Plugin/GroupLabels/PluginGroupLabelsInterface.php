<?php

declare(strict_types=1);

namespace Donquixote\Ock\Plugin\GroupLabels;

interface PluginGroupLabelsInterface {

  /**
   * @return \Donquixote\Ock\Text\TextInterface[]
   */
  public function getLabels(): array;

}
