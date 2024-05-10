<?php

declare(strict_types=1);

namespace Donquixote\Ock\Summarizer;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Ock\Formula\Primitive\Formula_ScalarInterface;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

#[Adapter]
class Summarizer_Scalar implements SummarizerInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Primitive\Formula_ScalarInterface $formula
   */
  public function __construct(
    private readonly Formula_ScalarInterface $formula,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): ?TextInterface {
    $type = gettype($conf);
    if (!in_array($type, $this->formula->getAllowedTypes())) {
      return Text::t('Incompatible type: Expected @expected, found @found')
        ->replaceS('@expected', implode('|',
          $this->formula->getAllowedTypes()))
        ->replaceS('@found', $type);
    }
    return Text::s(var_export($conf, TRUE));
  }

}
