<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Iface;

class Formula_Iface implements Formula_IfaceInterface {

  /**
   * Constructor.
   *
   * @param class-string $interface
   * @param bool $orNull
   */
  public function __construct(
    private readonly string $interface,
    private readonly bool $orNull = FALSE,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function allowsNull(): bool {
    return $this->orNull;
  }

  /**
   * {@inheritdoc}
   */
  public function getInterface(): string {
    return $this->interface;
  }

}
