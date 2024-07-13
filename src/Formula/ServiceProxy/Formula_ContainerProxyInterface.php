<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\ServiceProxy;

use Ock\Adaptism\Attribute\SelfAdapter;
use Ock\Ock\Core\Formula\FormulaInterface;
use Psr\Container\ContainerInterface;

interface Formula_ContainerProxyInterface extends FormulaInterface {

  /**
   * Gets the "real" formula with resolved dependencies.
   *
   * @param \Psr\Container\ContainerInterface $container
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Ock\Ock\Exception\FormulaException
   *
   * @noinspection PhpAttributeCanBeAddedToOverriddenMemberInspection
   */
  #[SelfAdapter]
  public function containerGetFormula(
    ContainerInterface $container,
  ): FormulaInterface;

}
