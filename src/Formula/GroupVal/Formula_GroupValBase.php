<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\GroupVal;

use Ock\Ock\Formula\Group\Formula_GroupInterface;

abstract class Formula_GroupValBase implements Formula_GroupValInterface {

  /**
   * Constructor.
   *
   * Same as the parent, but must be a group formula.
   *
   * @param \Ock\Ock\Formula\Group\Formula_GroupInterface $decorated
   */
  public function __construct(
    private readonly Formula_GroupInterface $decorated,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getDecorated(): Formula_GroupInterface {
    return $this->decorated;
  }

}
