<?php

declare(strict_types=1);

namespace Donquixote\Ock\Translator;

class Translator {

  /**
   * @return \Donquixote\Ock\Translator\TranslatorInterface
   */
  public static function passthru(): TranslatorInterface {
    return new Translator_Passthru();
  }

}
