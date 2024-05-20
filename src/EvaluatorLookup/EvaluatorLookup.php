<?php

declare(strict_types=1);

namespace Ock\Ock\EvaluatorLookup;

use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\DID\Attribute\Parameter\GetService;
use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\Evaluator\EvaluatorInterface;
use Ock\Ock\Formula\Formula;

class EvaluatorLookup implements EvaluatorLookupInterface {

  /**
   * @var array<class-string, EvaluatorInterface>
   */
  private array $evaluators = [];

  /**
   * Constructor.
   *
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $adapter
   */
  public function __construct(
    #[GetService]
    private readonly UniversalAdapterInterface $adapter,
  ) {}

  /**
   * @template T
   *
   * @param class-string<T> $interface
   *
   * @return EvaluatorInterface<T>
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  public function interfaceGetEvaluator(string $interface): EvaluatorInterface {
    return $this->evaluators[$interface]
      ??= $this->createEvaluator($interface);
  }

  /**
   * @template T as object
   *
   * @param class-string<T> $interface
   *
   * @return \Ock\Ock\Evaluator\EvaluatorInterface<T>
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  private function createEvaluator(string $interface): EvaluatorInterface {
    $formula = Formula::iface($interface);
    try {
      $evaluator = $this->adapter->adapt($formula, EvaluatorInterface::class);
    }
    catch (AdapterException $e) {
      throw new AdapterException(\sprintf(
        'Failed to obtain evaluator for %s',
        MessageUtil::formatValue($interface),
      ), 0, $e);
    }
    if (!$evaluator) {
      throw new AdapterException(\sprintf(
        'Failed to obtain evaluator for %s',
        MessageUtil::formatValue($interface),
      ));
    }
    return $evaluator;
  }

}
