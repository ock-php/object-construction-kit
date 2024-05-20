<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Fixture\IntFormat;

use Ock\Ock\Attribute\Parameter\OckAdaptee;
use Ock\Ock\Attribute\Plugin\OckPluginInstance;
use Ock\Ock\Attribute\PluginModifier\OckPluginAdapter;
use Ock\Ock\Tests\Fixture\NumberFormat\NumberFormatInterface;

/**
 * Adapter from NumberFormat to IntFormat.
 */
#[OckPluginInstance("numberFormat", "Number format adapter")]
#[OckPluginAdapter]
class IntFormat_NumberFormat implements IntFormatInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Tests\Fixture\NumberFormat\NumberFormatInterface $numberFormat
   */
  public function __construct(
    #[OckAdaptee]
    private readonly NumberFormatInterface $numberFormat,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function format(int $number): string {
    return $this->numberFormat->format($number);
  }

}
