<?php

declare(strict_types=1);

namespace Donquixote\Ock\Plugin;

class NamedPlugin {

  /**
   * Constructor.
   *
   * @param string $id
   *   Plugin id.
   * @param \Donquixote\Ock\Plugin\Plugin $plugin
   *   The actual plugin object.
   */
  public function __construct(
    private readonly string $id,
    private readonly Plugin $plugin,
  ) {}

  /**
   * @return string
   */
  public function getId(): string {
    return $this->id;
  }

  /**
   * @return \Donquixote\Ock\Plugin\Plugin
   */
  public function getPlugin(): Plugin {
    return $this->plugin;
  }

}
