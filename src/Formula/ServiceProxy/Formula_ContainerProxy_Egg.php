<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\ServiceProxy;

use Ock\DID\Exception\ContainerToValueException;
use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Exception\FormulaException;
use Ock\Egg\Egg\EggInterface;
use Psr\Container\ContainerInterface;

class Formula_ContainerProxy_Egg implements Formula_ContainerProxyInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Egg\Egg\EggInterface<FormulaInterface> $formulaEgg
   */
  public function __construct(
    private readonly EggInterface $formulaEgg,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function containerGetFormula(ContainerInterface $container): FormulaInterface {
    try {
      $candidate = $this->formulaEgg->hatch($container);
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
