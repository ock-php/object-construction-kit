<?php

declare(strict_types=1);

namespace Donquixote\Ock\Summarizer;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Ock\Formula\IdToLabel\Formula_IdToLabelInterface;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;
use Donquixote\Ock\Util\ConfUtil;

#[Adapter]
class Summarizer_IdToLabel implements SummarizerInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\IdToLabel\Formula_IdToLabelInterface $formula
   */
  public function __construct(
    private readonly Formula_IdToLabelInterface $formula,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): ?TextInterface {

    if (NULL === $id = ConfUtil::confGetId($conf)) {
      return Text::t('Required id missing.');
    }

    if (!$this->formula->idIsKnown($id)) {
      return Text::s($id)
        ->wrapT('@id', 'Unknown id "@id".');
    }

    return $this->formula->idGetLabel($id)
      ?? Text::s($id)
        ->wrapT('@id', 'Unnamed id "@id"');
  }

}
