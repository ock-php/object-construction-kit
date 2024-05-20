<?php

declare(strict_types=1);

namespace Ock\Ock\Summarizer;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Exception\FormulaException;
use Ock\Ock\Formula\Group\Formula_GroupInterface;
use Ock\Ock\Formula\Group\GroupHelper;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;

#[Adapter]
class Summarizer_Group implements SummarizerInterface {

  /**
   * @var \Ock\Ock\Formula\Group\GroupHelper
   *
   * @todo Make this a service?
   */
  private GroupHelper $groupHelper;

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\Group\Formula_GroupInterface $groupFormula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
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
