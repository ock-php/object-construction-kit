<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Ock\Ock\Formula\StringVal\Formula_StringValInterface;
use Ock\Ock\Formula\Textfield\Formula_TextfieldInterface;
use Ock\Ock\Text\Text;
use Ock\Ock\Translator\Translator;
use Ock\Ock\V2V\String\V2V_String_Trivial;
use Ock\Ock\V2V\String\V2V_StringInterface;

class Generator_Textfield implements GeneratorInterface {

  /**
   * @param \Ock\Ock\Formula\Textfield\Formula_TextfieldInterface $formula
   *
   * @return self
   */
  #[Adapter]
  public static function createFromStringFormula(Formula_TextfieldInterface $formula): Generator_Textfield {
    return new self($formula, new V2V_String_Trivial());
  }

  /**
   * @param \Ock\Ock\Formula\StringVal\Formula_StringValInterface $formula
   *
   * @return self
   */
  #[Adapter]
  public static function createFromStringValFormula(Formula_StringValInterface $formula): Generator_Textfield {
    return new self($formula->getDecorated(), $formula->getV2V());
  }

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Textfield\Formula_TextfieldInterface $formula
   * @param \Ock\Ock\V2V\String\V2V_StringInterface $v2v
   */
  public function __construct(
    private readonly Formula_TextfieldInterface $formula,
    private readonly V2V_StringInterface $v2v,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {

    if (!\is_string($conf)) {
      throw new GeneratorException_IncompatibleConfiguration(
        sprintf(
          'Expected a string, found %s.',
          MessageUtil::formatValue($conf)));
    }

    if ([] !== $errors = $this->formula->textGetValidationErrors($conf)) {
      throw new GeneratorException_IncompatibleConfiguration(
        sprintf(
          'Text %s fails validation: %s.',
          MessageUtil::formatValue($conf),
          Text::concat($errors, ', ')->convert(Translator::passthru())));
    }

    return $this->v2v->stringGetPhp($conf);
  }

}
