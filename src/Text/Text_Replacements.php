<?php

declare(strict_types=1);

namespace Ock\Ock\Text;

use Ock\Ock\Translator\TranslatorInterface;

class Text_Replacements extends TextBuilderBase {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Text\TextInterface $source
   * @param \Ock\Ock\Text\TextInterface[] $replacements
   */
  public function __construct(
    private readonly TextInterface $source,
    private array $replacements = [],
  ) {
    Text::validateMultiple($replacements);
  }

  public function __toString(): string {
    throw new \RuntimeException('Cannot print this.');
  }

  /**
   * {@inheritdoc}
   */
  public function replace(string $token, TextInterface $replacement): TextBuilderBase {
    $clone = clone $this;
    $clone->replacements[$token] = $replacement;
    return $clone;
  }

  /**
   * {@inheritdoc}
   */
  public function convert(TranslatorInterface $translator): string {
    $translated = $this->source->convert($translator);
    if (!$this->replacements) {
      return $translated;
    }
    $replacements = [];
    foreach ($this->replacements as $key => $replacement) {
      $replacements[$key] = $replacement->convert($translator);
    }
    return strtr($translated, $replacements);
  }

}
