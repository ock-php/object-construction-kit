<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Fixture\NumberFormat;

use Ock\Ock\Attribute\Parameter\OckOption;
use Ock\Ock\Attribute\Plugin\OckPluginInstance;
use Ock\Ock\Tests\Fixture\IntFormat\IntFormatInterface;

#[OckPluginInstance("intRounded", "Rounded as integer")]
// @todo Mark as adapter.
class NumberFormat_IntRounded implements NumberFormatInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Tests\Fixture\IntFormat\IntFormatInterface|null $intFormat
   *   Integer format for the rounded number, or NULL for trivial format.
   */
  public function __construct(
    #[OckOption('intFormat', 'Int format')]
    private readonly ?IntFormatInterface $intFormat = NULL,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function format(int|float $number): string {
    $integer = (int) round($number);
    return $this->intFormat?->format($integer) ?? (string) $integer;
  }

}
