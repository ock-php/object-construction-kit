<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Drilldown;

abstract class Formula_DrilldownBase implements Formula_DrilldownInterface {

  /**
   * Constructor.
   *
   * @param bool $orNull
   */
  public function __construct(
    private readonly bool $orNull = FALSE,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function allowsNull(): bool {
    return $this->orNull;
  }

}
