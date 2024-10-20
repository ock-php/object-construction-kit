<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Group;

use Ock\CodegenTools\Util\PhpUtil;

class V2V_Group_PhpPlaceholders implements V2V_GroupInterface {

  /**
   * Constructor.
   *
   * @param string $phpWithPlaceholders
   */
  public function __construct(
    private readonly string $phpWithPlaceholders,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
    $replacements = [];
    foreach ($itemsPhp as $key => $itemPhp) {
      $replacements[PhpUtil::phpPlaceholder($key)] = $itemPhp;
    }
    return strtr($this->phpWithPlaceholders, $replacements);
  }

}
