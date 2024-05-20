<?php

declare(strict_types=1);

namespace Ock\Ock\Translator;

class Translator {

  /**
   * @return \Ock\Ock\Translator\TranslatorInterface
   */
  public static function passthru(): TranslatorInterface {
    return new Translator_Passthru();
  }

}
