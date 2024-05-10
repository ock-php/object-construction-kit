<?php

declare(strict_types=1);

namespace Donquixote\Ock\Generator;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\CodegenTools\Util\CodeGen;
use Donquixote\Ock\Exception\GeneratorException;
use Donquixote\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Donquixote\Ock\Formula\Validator\Formula_ConstrainedValueInterface;
use Donquixote\Ock\Translator\Translator_Passthru;
use Donquixote\CodegenTools\Util\PhpUtil;

#[Adapter]
class Generator_ConstrainedValue implements GeneratorInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Validator\Formula_ConstrainedValueInterface $formula
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
