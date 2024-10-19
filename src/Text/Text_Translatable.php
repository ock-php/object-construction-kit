<?php

declare(strict_types=1);

namespace Ock\Ock\Text;

use Ock\Ock\Translator\TranslatorInterface;

/**
 * Simple translatable text.
 */
class Text_Translatable extends TextBuilderBase {

  /**
   * Constructor.
   *
   * @param string $source
   *   Text in source language, typically English.
   */
  public function __construct(
    private readonly string $source,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function convert(TranslatorInterface $translator): string {
    return $translator->translate($this->source);
  }

}
