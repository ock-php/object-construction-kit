<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Ock\Formula\Primitive\Formula_ScalarInterface;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

#[Adapter]
class Summarizer_Scalar implements SummarizerInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Primitive\Formula_ScalarInterface $formula
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
