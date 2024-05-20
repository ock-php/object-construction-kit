<?php

declare(strict_types=1);

namespace Ock\Ock\Text;

use Ock\Ock\Translator\TranslatorInterface;

/**
 * Generic interface for values that can be used as text.
 *
 * Some of these might need specific tools to actually build the text.
 */
interface TextInterface {

  /**
   * @param \Ock\Ock\Translator\TranslatorInterface $translator
   *
   * @return string
   */
  public function convert(TranslatorInterface $translator): string;

}
