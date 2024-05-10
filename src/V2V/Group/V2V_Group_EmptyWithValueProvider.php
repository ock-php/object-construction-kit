<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\Group;

use Donquixote\Ock\Exception\GeneratorException_UnsupportedConfiguration;
use Donquixote\Ock\Formula\ValueProvider\Formula_FixedPhpInterface;
use Donquixote\Helpers\Util\MessageUtil;

class V2V_Group_EmptyWithValueProvider implements V2V_GroupInterface {

  /**
   * Constructor.
   *
   * @param \Donquixote\Ock\Formula\ValueProvider\Formula_FixedPhpInterface $valueProvider
   */
  public function __construct(
    private readonly Formula_FixedPhpInterface $valueProvider,
  ) {}

  /**
   * {@inheritdoc}
   * @param array $conf
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
    if ([] !== $itemsPhp) {
      throw new GeneratorException_UnsupportedConfiguration(
        sprintf(
          'Expected an empty array, found %s.',
          MessageUtil::formatValue($itemsPhp),
        ),
      );
    }
    return $this->valueProvider->getPhp();
  }

}
