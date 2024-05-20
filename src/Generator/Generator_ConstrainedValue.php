<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\CodegenTools\Util\CodeGen;
use Ock\Ock\Exception\GeneratorException;
use Ock\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Ock\Ock\Formula\Validator\Formula_ConstrainedValueInterface;
use Ock\Ock\Translator\Translator_Passthru;

#[Adapter]
class Generator_ConstrainedValue implements GeneratorInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Validator\Formula_ConstrainedValueInterface $formula
   */
  public function __construct(
    #[Adaptee]
    private readonly Formula_ConstrainedValueInterface $formula,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {
    foreach ($this->formula->validate($conf) as $error) {
      throw new GeneratorException_IncompatibleConfiguration(
        $error->convert(new Translator_Passthru()),
      );
    }
    try {
      return CodeGen::phpValue($conf);
    }
    catch (\Exception $e) {
      throw new GeneratorException($e->getMessage(), 0, $e);
    }
  }

}
