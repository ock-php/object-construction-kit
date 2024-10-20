<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Group;

use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\Exception\GeneratorException_UnsupportedConfiguration;
use Ock\Ock\Formula\ValueProvider\Formula_FixedPhpInterface;

class V2V_Group_EmptyWithValueProvider implements V2V_GroupInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Ock\Formula\ValueProvider\Formula_FixedPhpInterface $valueProvider
   */
  public function __construct(
    private readonly Formula_FixedPhpInterface $valueProvider,
  ) {}

  /**
   * {@inheritdoc}
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
