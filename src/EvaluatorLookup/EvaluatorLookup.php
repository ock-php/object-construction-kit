<?php

declare(strict_types=1);

namespace Donquixote\Ock\EvaluatorLookup;

use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\DID\Attribute\Parameter\GetService;
use Donquixote\Helpers\Util\MessageUtil;
use Donquixote\Ock\Evaluator\EvaluatorInterface;
use Donquixote\Ock\Formula\Formula;

class EvaluatorLookup implements EvaluatorLookupInterface {

  /**
   * @var array<class-string, EvaluatorInterface>
   */
  private array $evaluators = [];

  /**
   * Constructor.
   *
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $adapter
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
   * @throws \Donquixote\Adaptism\Exception\AdapterException
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
   * @return \Donquixote\Ock\Evaluator\EvaluatorInterface<T>
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
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
