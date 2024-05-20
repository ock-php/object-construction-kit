<?php

declare(strict_types=1);

namespace Ock\Ock\Evaluator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Attribute\Parameter\UniversalAdapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\DID\Attribute\Parameter\GetService;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Exception\EvaluatorException;
use Ock\Ock\Exception\GeneratorException;
use Ock\Ock\Generator\Generator;
use Ock\Ock\Generator\GeneratorInterface;
use Psr\Container\ContainerInterface;

class Evaluator_GeneratorEval implements EvaluatorInterface {

  /**
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   * @param \Psr\Container\ContainerInterface $container
   *
   * @return \Ock\Ock\Evaluator\EvaluatorInterface
   * @throws \Ock\Adaptism\Exception\AdapterException
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
   * @param \Ock\Ock\Generator\GeneratorInterface $generator
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
