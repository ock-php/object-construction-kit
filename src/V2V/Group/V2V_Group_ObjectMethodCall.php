<?php

declare(strict_types=1);

namespace Donquixote\Ock\V2V\Group;

use Donquixote\CodegenTools\Util\CodeGen;
use Donquixote\CodegenTools\Util\PhpUtil;

class V2V_Group_ObjectMethodCall implements V2V_GroupInterface {

  /**
   * Constructor.
   *
   * @param string $objectKey
   * @param string $method
   * @param list<string> $paramKeys
   */
  public function __construct(
    private readonly string $objectKey,
    private readonly string $method,
    private readonly array $paramKeys,
  ) {}

  /**
   * {@inheritdoc}
   * @param array $conf
   */
  public function itemsPhpGetPhp(array $itemsPhp, array $conf): string {
    $paramsPhp = [];
    foreach ($this->paramKeys as $paramPos => $sourceKey) {
      $paramsPhp[$paramPos] = $itemsPhp[$sourceKey];
    }
    return CodeGen::phpCallMethod($itemsPhp[$this->objectKey], $this->method, $paramsPhp);
  }

}
