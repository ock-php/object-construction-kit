<?php

declare(strict_types=1);

namespace Donquixote\Ock\Text;

use Donquixote\Ock\Translator\TranslatorInterface;

/**
 * Raw text, potentially unsafe for output.
 */
class Text_Raw extends TextBuilderBase {

  /**
   * Constructor.
   *
   * @param string $source
   */
  public function __construct(
    private readonly string $source,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function convert(TranslatorInterface $translator): string {
    return $this->source;
  }

}
