<?php

declare(strict_types=1);

namespace Donquixote\Ock\Evaluator;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\Adaptism\Attribute\Parameter\UniversalAdapter;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\DID\Attribute\Parameter\GetService;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Exception\EvaluatorException;
use Donquixote\Ock\Exception\GeneratorException;
use Donquixote\Ock\Generator\Generator;
use Donquixote\Ock\Generator\GeneratorInterface;
use Psr\Container\ContainerInterface;

class Evaluator_GeneratorEval implements EvaluatorInterface {

  /**
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   * @param \Psr\Container\ContainerInterface $container
   *
   * @return \Donquixote\Ock\Evaluator\EvaluatorInterface
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function create(
    #[Adaptee] FormulaInterface $formula,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
    #[GetService] ContainerInterface $container,
  ): EvaluatorInterface {
    $generator = Generator::fromFormula($formula, $universalAdapter);
    return new self($generator, $container);
  }

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Generator\GeneratorInterface $generator
   * @param \Psr\Container\ContainerInterface $container
   */
  public function __construct(
    private readonly GeneratorInterface $generator,
    private readonly ContainerInterface $container,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetValue(mixed $conf): mixed {
    try {
      $php = $this->generator->confGetPhp($conf);
    }
    catch (GeneratorException $e) {
      throw new EvaluatorException($e->getMessage(), 0, $e);
    }
    // phpcs:ignore
    try {
      /** @var \Closure $closure */
      $closure = eval("return static function (\$container) {return $php;};");
      return $closure( $this->container);
    }
    catch (\Throwable $e) {
      throw new EvaluatorException(sprintf(
        "Error in line %d of eval'd code.\nMessage: %s\nExpression: %s",
        $e->getLine(),
        $e->getMessage(),
        $php,
      ), 0, $e);
    }
  }

}
