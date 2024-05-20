<?php

declare(strict_types=1);

namespace Ock\Ock\Plugin\GroupLabels;

interface PluginGroupLabelsInterface {

  /**
   * @return \Ock\Ock\Text\TextInterface[]
   */
  public function getLabels(): array;

}
