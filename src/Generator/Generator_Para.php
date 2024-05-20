<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Exception\GeneratorException;
use Ock\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Ock\Ock\Formula\Para\Formula_ParaInterface;

class Generator_Para implements GeneratorInterface {

  /**
   * @param \Ock\Ock\Formula\Para\Formula_ParaInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  #[Adapter]
  public static function create(Formula_ParaInterface $formula, UniversalAdapterInterface $universalAdapter): Generator_Para {
    return new self(
      Generator::fromFormula($formula->getDecorated(), $universalAdapter),
      Generator::fromFormula($formula->getParaFormula(), $universalAdapter));
  }

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Generator\GeneratorInterface $decorated
   * @param \Ock\Ock\Generator\GeneratorInterface $paraGenerator
   */
  public function __construct(
    private readonly GeneratorInterface $decorated,
    private readonly GeneratorInterface $paraGenerator,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {

    $paraConfPhp = $this->decorated->confGetPhp($conf);

    try {
      // @todo Use a service that can pass in variables!
      // phpcs:ignore
      $paraConf = eval($paraConfPhp);
    }
    catch (\Exception $e) {
      // Use 'if' instead of separate 'catch' to avoid false inspection.
      // See https://youtrack.jetbrains.com/issue/WI-62853.
      if ($e instanceof GeneratorException) {
        // Exception already has the correct type.
        throw $e;
      }
      // Wrong exception type. Convert.
      throw new GeneratorException_IncompatibleConfiguration(
        $e->getMessage(), 0, $e);
    }

    return $this->paraGenerator->confGetPhp($paraConf);
  }

}
