<?php

declare(strict_types=1);

namespace Donquixote\Ock\Optionlessness;

use Donquixote\Adaptism\Exception\AdapterException;
use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\FormulaAdapter;

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
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
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
   * @param \Donquixote\Ock\Core\Formula\FormulaInterface $formula
   * @param \Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface $universalAdapter
   *
   * @return \Donquixote\Ock\Optionlessness\OptionlessnessInterface|null
   *
   * @throws \Donquixote\Adaptism\Exception\AdapterException
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
