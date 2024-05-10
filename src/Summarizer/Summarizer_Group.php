<?php

declare(strict_types=1);

namespace Donquixote\Ock\Summarizer;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Exception\FormulaException;
use Donquixote\Ock\Formula\Group\Formula_GroupInterface;
use Donquixote\Ock\Formula\Group\GroupHelper;
use Donquixote\Ock\Text\Text;
use Donquixote\Ock\Text\TextInterface;

#[Adapter]
class Summarizer_Group implements SummarizerInterface {

  /**
   * @var \Donquixote\Ock\Formula\Group\GroupHelper
   *
   * @todo Make this a service?
   */
  private GroupHelper $groupHelper;

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Group\Formula_GroupInterface $groupFormula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   */
  public function __construct(
    private readonly Formula_GroupInterface $groupFormula,
    UniversalAdapterInterface $universalAdapter,
  ) {
    $this->groupHelper = new GroupHelper($universalAdapter);
  }

  /**
   * {@inheritdoc}
   */
  public function confGetSummary(mixed $conf): ?TextInterface {

    if (!\is_array($conf)) {
      $conf = [];
    }

    $resolvedGroup = $this->groupHelper
      ->withOriginalItems($this->groupFormula->getItems())
      ->withConf($conf);

    $parts = [];
    foreach ($resolvedGroup->getKeys() as $key) {
      try {
        $itemSummary = $resolvedGroup
          ->keyGetObject($key, SummarizerInterface::class)
          ->confGetSummary($conf[$key] ?? NULL);
        if ($itemSummary === NULL) {
          continue;
        }
      }
      catch (AdapterException|FormulaException) {
        $itemSummary = Text::t('summary not available')->wrapSprintf('(%s)');
      }
      try {
        $label = $resolvedGroup->keyGetLabel($key);
      }
      catch (FormulaException) {
        $label = Text::s($key);
      }
      $parts[] = Text::label($label, $itemSummary);
    }

    return $parts ? Text::ul($parts) : NULL;
  }

}
