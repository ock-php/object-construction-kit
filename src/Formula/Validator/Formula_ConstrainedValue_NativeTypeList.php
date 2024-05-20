<?php

declare(strict_types=1);

namespace Ock\Ock\Formula\Validator;

use Ock\Helpers\Util\MessageUtil;
use Ock\Ock\Text\Text;

class Formula_ConstrainedValue_NativeTypeList implements Formula_ConstrainedValueInterface {

  /**
   * Constructor.
   *
   * @param string[] $allowedTypes
   *   Allowed type names, e.g. 'int', 'float', 'string' etc.
   */
  public function __construct(
    private readonly array $allowedTypes,
  ) {}

  /**
   * @inheritDoc
   */
  public function validate(mixed $conf): \Iterator {
    if (!in_array(get_debug_type($conf), $this->allowedTypes)) {
      yield Text::t('Incompatible type: Expected @expected, found @found')
        ->replaceS(
          '@expected',
          implode('|', $this->allowedTypes),
        )
        ->replaceS(
          '@found',
          MessageUtil::formatValue($conf),
        );
    }
  }

}
