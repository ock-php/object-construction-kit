<?php

declare(strict_types=1);

namespace Donquixote\Ock\Text;

use Donquixote\Ock\Translator\TranslatorInterface;

class Text_FluentDecorator extends TextBase {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Text\TextInterface $decorated
   */
  public function __construct(
    private readonly TextInterface $decorated,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function convert(TranslatorInterface $translator): string {
    return $this->decorated->convert($translator);
  }

  /**
   * {@inheritdoc}
   */
  protected function getThis(): TextInterface {
    return $this->decorated;
  }

}
