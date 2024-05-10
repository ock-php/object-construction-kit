<?php

declare(strict_types=1);

namespace Donquixote\Ock\EvaluatorLookup;

interface EvaluatorLookupInterface {

  /**
   * @template T as object
   *
   * @param class-string<T> $interface
   *
   * @return \Donquixote\Ock\Evaluator\EvaluatorInterface<T>
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  public function interfaceGetEvaluator(string $interface): object;

}
