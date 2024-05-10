<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\ServiceProxy;

use Donquixote\DID\ContainerToValue\ContainerToValueInterface;
use Donquixote\DID\Exception\ContainerToValueException;
use Donquixote\Helpers\Util\MessageUtil;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Exception\FormulaException;
use Psr\Container\ContainerInterface;

class Formula_ContainerProxy_CTV implements Formula_ContainerProxyInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\DID\ContainerToValue\ContainerToValueInterface<FormulaInterface> $formulaCTV
   */
  public function __construct(
    private readonly ContainerToValueInterface $formulaCTV,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function containerGetFormula(ContainerInterface $container): FormulaInterface {
    try {
      $candidate = $this->formulaCTV->containerGetValue($container);
    }
    catch (ContainerToValueException $e) {
      throw new FormulaException($e->getMessage(), 0, $e);
    }
    if ($candidate === NULL || $candidate instanceof FormulaInterface) {
      return $candidate;
    }
    throw new FormulaException(sprintf(
      'Expected a formula, found %s',
      MessageUtil::formatValue($candidate),
    ));
  }

}
