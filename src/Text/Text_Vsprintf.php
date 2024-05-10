<?php

declare(strict_types=1);

namespace Donquixote\Ock\Text;

use Donquixote\Ock\Translator\TranslatorInterface;

class Text_Vsprintf extends TextBase {

  /**
   * Constructor.
   *
   * @param string $source
   * @param \Donquixote\Ock\Text\TextInterface[] $replacements
   */
  public function __construct(
    private readonly string $source,
    private readonly array $replacements,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function convert(TranslatorInterface $translator): string {
    $replacements = [];
    foreach ($this->replacements as $replacement) {
      $replacements[] = $replacement->convert($translator);
    }
    return vsprintf($this->source, $replacements);
  }

}
