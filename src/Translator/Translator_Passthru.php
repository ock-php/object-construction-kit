<?php

declare(strict_types=1);

namespace Ock\Ock\Translator;

class Translator_Passthru implements TranslatorInterface {

  /**
   * {@inheritdoc}
   */
  public function translate(string $source): string {
    return $source;
  }

}
