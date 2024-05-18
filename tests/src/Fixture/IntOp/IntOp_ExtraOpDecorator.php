<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests\Fixture\IntOp;

use Donquixote\Ock\Attribute\Parameter\OckDecorated;
use Donquixote\Ock\Attribute\Parameter\OckOption;
use Donquixote\Ock\Attribute\Plugin\OckPluginInstance;
use Donquixote\Ock\Attribute\PluginModifier\OckPluginDecorator;

/**
 * Decorator which applies an additional operation.
 */
#[OckPluginInstance("extraOpDecorator", "Decorator with additional operation")]
#[OckPluginDecorator]
class IntOp_ExtraOpDecorator implements IntOpInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Tests\Fixture\IntOp\IntOpInterface $decorated
   *   Decorated operation.
   * @param \Donquixote\Ock\Tests\Fixture\IntOp\IntOpInterface $extraOp
   *   Additional operation to run afterwards.
   */
  public function __construct(
    #[OckDecorated]
    private readonly IntOpInterface $decorated,
    #[OckOption('extraOp', 'Extra op')]
    private readonly IntOpInterface $extraOp,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function transform(int $number): int {
    $result = $this->decorated->transform($number);
    return $this->extraOp->transform($result);
  }

}
