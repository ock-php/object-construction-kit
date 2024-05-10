<?php

declare(strict_types=1);

namespace Donquixote\Ock\Generator;

use Donquixote\Adaptism\Attribute\Adapter;
use Donquixote\Adaptism\Attribute\Parameter\Adaptee;
use Donquixote\Adaptism\Attribute\Parameter\UniversalAdapter;
use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Helpers\Util\MessageUtil;
use Donquixote\Ock\Exception\FormulaException;
use Donquixote\Ock\Exception\GeneratorException;
use Donquixote\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Donquixote\Ock\Formula\Group\Formula_GroupInterface;
use Donquixote\Ock\Formula\Group\GroupHelper;
use Donquixote\Ock\Formula\GroupVal\Formula_GroupValInterface;
use Donquixote\Ock\V2V\Group\V2V_Group_Trivial;
use Donquixote\Ock\V2V\Group\V2V_GroupInterface;

class Generator_Group implements GeneratorInterface {

  /**
   * @var \Donquixote\Ock\Formula\Group\GroupHelper
   *
   * @todo Make this a service?
   */
  private GroupHelper $groupHelper;

  /**
   * @param \Donquixote\Ock\Formula\Group\Formula_GroupInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self|null
   */
  #[Adapter]
  public static function createFromGroupFormula(
    #[Adaptee] Formula_GroupInterface $formula,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
  ): ?self {
    return new self($formula, new V2V_Group_Trivial(), $universalAdapter);
  }

  /**
   * @param \Donquixote\Ock\Formula\GroupVal\Formula_GroupValInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return self|null
   */
  #[Adapter]
  public static function createFromGroupValFormula(
    #[Adaptee] Formula_GroupValInterface $formula,
    #[UniversalAdapter] UniversalAdapterInterface $universalAdapter,
  ): ?self {
    return new self($formula->getDecorated(), $formula->getV2V(), $universalAdapter);
  }

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\Group\Formula_GroupInterface $groupFormula
   * @param \Donquixote\Ock\V2V\Group\V2V_GroupInterface $v2v
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   */
  protected function __construct(
    private readonly Formula_GroupInterface $groupFormula,
    private readonly V2V_GroupInterface $v2v,
    UniversalAdapterInterface $universalAdapter,
  ) {
    $this->groupHelper = new GroupHelper($universalAdapter);
  }

  /**
   * {@inheritdoc}
   */
  public function confGetPhp(mixed $conf): string {
    if ($conf === null) {
      $conf = [];
    }
    elseif (!\is_array($conf)) {
      throw new GeneratorException_IncompatibleConfiguration(sprintf(
        'Expected an array, found %s.',
        MessageUtil::formatValue($conf),
      ));
    }

    try {
      // See https://youtrack.jetbrains.com/issue/WI-70359/Psalm-Template-array-type-not-inferred.
      /** @var \Donquixote\Ock\Generator\GeneratorInterface[] $generators */
      $generators = $this->groupHelper
        ->withOriginalItems($this->groupFormula->getItems())
        ->withConf($conf)
        ->getObjects(GeneratorInterface::class);
    }
    catch (FormulaException|AdapterException $e) {
      throw new GeneratorException('Failing group formula.', 0, $e);
    }

    $phpStatements = [];
    foreach ($generators as $key => $itemGenerator) {
      // @todo Complain if setting is missing, instead of assuming NULL?
      $itemConf = $conf[$key] ?? NULL;
      $phpStatements[$key] = $itemGenerator->confGetPhp($itemConf);
    }

    return $this->v2v->itemsPhpGetPhp($phpStatements, $conf);
  }

}
