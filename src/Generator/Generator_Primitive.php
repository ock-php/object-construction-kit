<?php

declare(strict_types=1);

namespace Donquixote\Ock\Generator;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Donquixote\Ock\Formula\Primitive\Formula_ScalarInterface;
use Donquixote\CodegenTools\Util\MessageUtil;

class Generator_Primitive implements GeneratorInterface {

  /**
   * @param \Donquixote\Ock\Formula\Primitive\Formula_ScalarInterface $formula
   *
   * @return self
   */
  #[Adapter]
  public static function fromFormula(Formula_ScalarInterface $formula): Generator_Primitive {
    return new self($formula);
  }

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Primitive\Formula_ScalarInterface $formula
   */
  public function __construct(
    private readonly Formula_ScalarInterface $formula,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {
    $type = gettype($conf);
    if (!in_array($type, $this->formula->getAllowedTypes())) {
      throw new GeneratorException_IncompatibleConfiguration(
        sprintf(
          'Expected %s, but found %s.',
          implode('|', $this->formula->getAllowedTypes()),
          MessageUtil::formatValue($conf)));
    }
    return var_export($conf, TRUE);
  }

}
