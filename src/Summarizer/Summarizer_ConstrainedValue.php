<?php

declare(strict_types=1);

namespace Donquixote\Ock\Summarizer;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\CodegenTools\Util\CodeGen;
use Donquixote\Helpers\Util\MessageUtil;
use Donquixote\Ock\Formula\Validator\Formula_ConstrainedValueInterface;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

#[Adapter]
class Summarizer_ConstrainedValue implements SummarizerInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Validator\Formula_ConstrainedValueInterface $formula
   */
  public function __construct(
    #[Adaptee]
    private readonly Formula_ConstrainedValueInterface $formula,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): ?TextInterface {
    foreach ($this->formula->validate($conf) as $error) {
      return Text::label(
        Text::t('Incompatible configuration'),
        $error,
      );
    }
    try {
      return Text::s(CodeGen::phpValue($conf));
    }
    catch (\Exception $e) {
      return Text::s(MessageUtil::formatValue($conf));
    }
  }

}
