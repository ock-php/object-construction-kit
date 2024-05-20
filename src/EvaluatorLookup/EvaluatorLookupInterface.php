<?php

declare(strict_types=1);

namespace Ock\Ock\EvaluatorLookup;

interface EvaluatorLookupInterface {

  /**
   * @template T as object
   *
   * @param class-string<T> $interface
   *
   * @return \Ock\Ock\Evaluator\EvaluatorInterface<T>
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  public function interfaceGetEvaluator(string $interface): object;

}
