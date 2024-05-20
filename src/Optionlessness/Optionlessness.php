<?php

declare(strict_types=1);

namespace Ock\Ock\Optionlessness;

use Ock\Adaptism\Exception\AdapterException;
use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\FormulaAdapter;

class Optionlessness implements OptionlessnessInterface {

  /**
   * Constructor.
   *
   * @param bool $optionless
   */
  public function __construct(
    private readonly bool $optionless,
  ) {}

  /**
   * Determines whether a formula is optionless.
   *
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return bool
   */
  public static function checkFormula(FormulaInterface $formula, UniversalAdapterInterface $universalAdapter): bool {
    try {
      return self::fromFormula($formula, $universalAdapter)?->isOptionless() ?? FALSE;
    }
    catch (AdapterException) {
      // Assume it is not optionless.
      return FALSE;
    }
  }

  /**
   * @param \Ock\Ock\Core\Formula\FormulaInterface $formula
   * @param \Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Ock\Ock\Optionlessness\OptionlessnessInterface|null
   *
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  public static function fromFormula(FormulaInterface $formula, UniversalAdapterInterface $universalAdapter): ?OptionlessnessInterface {
    return FormulaAdapter::getObject(
      $formula,
      OptionlessnessInterface::class,
      $universalAdapter,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function isOptionless(): bool {
    return $this->optionless;
  }

}
