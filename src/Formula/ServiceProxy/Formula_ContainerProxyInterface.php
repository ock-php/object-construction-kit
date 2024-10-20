<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\ServiceProxy;

use Ock\Adaptism\Attribute\SelfAdapter;
use Ock\Ock\Core\Formula\FormulaInterface;
use Psr\Container\ContainerInterface;

/**
 * Proxy formula that provides the real formula when given a service container.
 */
interface Formula_ContainerProxyInterface extends FormulaInterface {

  /**
   * Gets the "real" formula with resolved dependencies.
   *
   * @param \Psr\Container\ContainerInterface $container
   *   Service container from which to get a formula.
   *
   * @return \Ock\Ock\Core\Formula\FormulaInterface
   *   The formula.
   *
   * @throws \Ock\Ock\Exception\FormulaException
   *   The formula cannot be created or found.
   *
   * @noinspection PhpAttributeCanBeAddedToOverriddenMemberInspection
   */
  #[SelfAdapter]
  public function containerGetFormula(
    ContainerInterface $container,
  ): FormulaInterface;

}
