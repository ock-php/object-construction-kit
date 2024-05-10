<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests\Translator;

use Donquixote\Ock\Translator\TranslatorInterface;

class Translator_Test implements TranslatorInterface {

  /**
   * {@inheritdoc}
   */
  public function translate(string $source): string {
    return sprintf('<t>%s</t>', $source);
  }

}
