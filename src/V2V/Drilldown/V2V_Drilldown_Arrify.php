<?php

declare(strict_types=1);

namespace Ock\Ock\V2V\Drilldown;

class V2V_Drilldown_Arrify implements V2V_DrilldownInterface {

  /**
   * Constructor.
   *
   * @param string $idKey
   * @param string $optionsKey
   */
  public function __construct(
    private readonly string $idKey = 'id',
    private readonly string $optionsKey = 'options',
  ) {}

  /**
   * {@inheritdoc}
   */
  final public function idPhpGetPhp(int|string $id, string $php): string {
    $idKeyPhp = var_export($this->idKey, TRUE);
    $optionsKeyPhp = var_export($this->optionsKey, TRUE);
    $idPhp = var_export($id, TRUE);
    return <<<EOT
[
  $idKeyPhp => $idPhp,
  $optionsKeyPhp => $php,
];
EOT;
  }

}
