<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\ServiceProxy;

use Donquixote\Adaptism\Attribute\SelfAdapter;
use Donquixote\DID\Attribute\Parameter\GetService;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Psr\Container\ContainerInterface;

interface Formula_ContainerProxyInterface extends FormulaInterface {

  /**
   * Gets the "real" formula with resolved dependencies.
   *
   * @param \Psr\Container\ContainerInterface $container
   *
   * @return \Donquixote\Ock\Core\Formula\FormulaInterface
   *
   * @throws \Donquixote\Ock\Exception\FormulaException
   *
   * @noinspection PhpAttributeCanBeAddedToOverriddenMemberInspection
   */
  #[SelfAdapter]
  public function containerGetFormula(
    #[GetService] ContainerInterface $container,
  ): FormulaInterface;

}
