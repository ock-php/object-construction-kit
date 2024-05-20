<?php

declare(strict_types=1);

namespace Ock\Ock\Text;

use Ock\Ock\Translator\TranslatorInterface;

class Text_Translatable extends TextBuilderBase {

  /**
   * Constructor.
   *
   * @param string $source
   */
  public function __construct(
    private readonly string $source,
  ) {}

  /**
   * @param \Ock\Ock\Translator\TranslatorInterface $translator
   *
   * @return string
   */
  public function convert(TranslatorInterface $translator): string {
    return $translator->translate($this->source);
  }

}
