<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\CodegenTools\Util\CodeGen;
use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\Formula\Validator\Formula_ConstrainedValueInterface;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

#[Adapter]
class Summarizer_ConstrainedValue implements SummarizerInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Validator\Formula_ConstrainedValueInterface $formula
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
