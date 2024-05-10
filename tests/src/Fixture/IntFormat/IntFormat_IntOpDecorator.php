<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests\Fixture\IntFormat;

use Donquixote\Ock\Attribute\Parameter\OckDecorated;
use Donquixote\Ock\Attribute\Parameter\OckOption;
use Donquixote\Ock\Attribute\Plugin\OckPluginInstance;
use Donquixote\Ock\Attribute\PluginModifier\OckPluginDecorator;
use Donquixote\Ock\Tests\Fixture\IntOp\IntOpInterface;

#[OckPluginInstance('intOpDecorator', 'Integer operation decorator')]
#[OckPluginDecorator]
class IntFormat_IntOpDecorator implements IntFormatInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Tests\Fixture\IntFormat\IntFormatInterface|null $decorated
   * @param \Donquixote\Ock\Tests\Fixture\IntOp\IntOpInterface $intOp
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
    return $this->decorated->format($number);
  }

}
