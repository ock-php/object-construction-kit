<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Textfield;

use Ock\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Ock\Ock\Formula\StringVal\Formula_StringVal;
use Ock\Ock\Text\Text;
use Ock\Ock\Translator\Translator;
use Ock\Ock\V2V\String\V2V_StringInterface;

abstract class Formula_Textfield_IntegerBase extends Formula_TextfieldBase implements V2V_StringInterface {

  /**
   * @return \Ock\Ock\Formula\StringVal\Formula_StringVal
   */
  public function createValFormula(): Formula_StringVal {
    return new Formula_StringVal($this, $this);
  }

  /**
   * {@inheritdoc}
   */
  public function textGetValidationErrors(string $text): array {

    $errors = [];

    if ((string) (int) $text !== $text) {
      $errors[] = Text::t("Value must be an integer.");
      return $errors;
    }

    return $this->numberGetValidationErrors((int) $text);
  }

  /**
   * @param int $number
   *
   * @return \Ock\Ock\Text\TextInterface[]
   */
  protected function numberGetValidationErrors(int $number): array {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function stringGetPhp(string $string): string {

    if ([] !== $errors = $this->textGetValidationErrors($string)) {
      $error_text = reset($errors);
      // Exception messages don't need to be translated.
      $error_str = $error_text->convert(Translator::passthru());
      throw new GeneratorException_IncompatibleConfiguration($error_str);
    }

    return var_export((int) $string, TRUE);
  }

}
