<?php

declare(strict_types=1);

namespace Donquixote\Ock\Text;

use Donquixote\Ock\Translator\TranslatorInterface;

/**
 * Generic interface for values that can be used as text.
 *
 * Some of these might need specific tools to actually build the text.
 */
interface TextInterface {

  /**
   * @param \Donquixote\Ock\Translator\TranslatorInterface $translator
   *
   * @return string
   */
  public function convert(TranslatorInterface $translator): string;

}
