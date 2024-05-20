<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Textfield;

use Ock\Ock\Text\TextInterface;

class Formula_Textfield_NoValidation implements Formula_TextfieldInterface {

  /**
   * {@inheritdoc}
   */
  public function getDescription(): ?TextInterface {
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function textIsValid(string $text): bool {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function textGetValidationErrors(string $text): array {
    return [];
  }

}
