<?php

declare(strict_types=1);

namespace Ock\Ock\Generator;

use Ock\Adaptism\Attribute\Adapter;
use Ock\Adaptism\Attribute\Parameter\Adaptee;
use Ock\Adaptism\Attribute\Parameter\UniversalAdapter;
use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\Exception\FormulaException;
use Ock\Ock\Exception\GeneratorException;
use Ock\Ock\Exception\GeneratorException_IncompatibleConfiguration;
use Ock\Ock\Formula\Group\Formula_GroupInterface;
use Ock\Ock\Formula\Group\GroupHelper;
use Ock\Ock\Formula\GroupVal\Formula_GroupValInterface;
use Ock\Ock\V2V\Group\V2V_Group_Trivial;
use Ock\Ock\V2V\Group\V2V_GroupInterface;

class Generator_Group implements GeneratorInterface {

  /**
   * @var \Ock\Ock\Formula\Group\GroupHelper
   *
   * @todo Make this a service?
   */
  private GroupHelper $groupHelper;

  /**
   * @param \Ock\Ock\Formula\Group\Formula_GroupInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
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
   * @param \Ock\Ock\Formula\GroupVal\Formula_GroupValInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
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
   * @param \Ock\Ock\Formula\Group\Formula_GroupInterface $groupFormula
   * @param \Ock\Ock\V2V\Group\V2V_GroupInterface $v2v
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
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
      /** @var \Ock\Ock\Generator\GeneratorInterface[] $generators */
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
