<?php

declare(strict_types=1);

namespace Ock\Ock\Tests\Fixture\IntFormat;

use Ock\Ock\Attribute\Parameter\OckDecorated;
use Ock\Ock\Attribute\Parameter\OckOption;
use Ock\Ock\Attribute\Plugin\OckPluginInstance;
use Ock\Ock\Attribute\PluginModifier\OckPluginDecorator;
use Ock\Ock\Tests\Fixture\IntOp\IntOpInterface;

#[OckPluginInstance('intOpDecorator', 'Integer operation decorator')]
#[OckPluginDecorator]
class IntFormat_IntOpDecorator implements IntFormatInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Tests\Fixture\IntFormat\IntFormatInterface|null $decorated
   * @param \Ock\Ock\Tests\Fixture\IntOp\IntOpInterface $intOp
   */
  public function __construct(
    #[OckDecorated]
    private readonly ?IntFormatInterface $decorated,
    #[OckOption('operation', 'Operation')]
    private readonly IntOpInterface $intOp,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function format(int $number): string {
    $number = $this->intOp->transform($number);
    if ($this->decorated === null) {
      return (string) $number;
    }
    return $this->decorated->format($number);
  }

}
