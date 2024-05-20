<?php

declare(strict_types=1);

namespace Ock\Ock\Plugin;

class NamedPlugin {

  /**
   * Constructor.
   *
   * @param string $id
   *   Plugin id.
   * @param \Ock\Ock\Plugin\Plugin $plugin
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
   * @return \Ock\Ock\Plugin\Plugin
   */
  public function getPlugin(): Plugin {
    return $this->plugin;
  }

}
