<?php

declare(strict_types=1);

namespace Ock\Ock\Translator;

interface TranslatorInterface {

  /**
   * @param string $source
   *   Source text which may or may not contain placeholders.
   *
   * @return string
   *   Translated text.
   */
  public function translate(string $source): string;

}
