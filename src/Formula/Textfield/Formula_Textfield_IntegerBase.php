<?php

declare(strict_types=1);

namespace Donquixote\Ock\Formula\Textfield;

use Donquixote\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Donquixote\Ock\Formula\StringVal\Formula_StringVal;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\V2V\String\V2V_StringInterface;

abstract class Formula_Textfield_IntegerBase extends Formula_TextfieldBase implements V2V_StringInterface {

  /**
   * @return \Donquixote\Ock\Formula\StringVal\Formula_StringVal
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
   * @return \Donquixote\Ock\Text\TextInterface[]
   */
  protected function numberGetValidationErrors(int $number): array {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function stringGetPhp(string $string): string {

    if ([] !== $errors = $this->textGetValidationErrors($string)) {
      throw new GeneratorException_IncompatibleConfiguration(reset($errors));
    }

    return var_export((int) $string, TRUE);
  }

}
