<?php

declare(strict_types=1);

namespace Ock\Ock\Text;

use Ock\Ock\Translator\TranslatorInterface;

class Text_SprintfOne extends TextBase {

  /**
   * Constructor.
   *
   * @param string $source
   * @param \Ock\Ock\Text\TextInterface $replacement
   */
  public function __construct(
    private readonly string $source,
    private readonly TextInterface $replacement,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function convert(TranslatorInterface $translator): string {
    return sprintf(
      $this->source,
      $this->replacement->convert($translator),
    );
  }

}
