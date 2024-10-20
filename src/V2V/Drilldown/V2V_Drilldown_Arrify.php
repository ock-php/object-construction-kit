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
   * Creates a new instance, but allows for $optionsKey to be NULL.
   *
   * @param string $idKey
   *   Array key for the id in the value expression.
   * @param string|null $optionsKey
   *   Array key for the value expression from the sub-formula.
   *   If this is NULL, the sub-expression will be placed at the top level.
   *   This assumes that the sub-expression produces an array, otherwise it
   *   won't work.
   *
   * @return \Ock\Ock\V2V\Drilldown\V2V_DrilldownInterface
   *   New instance.
   */
  public static function create(
    string $idKey = 'id',
    ?string $optionsKey = 'options',
  ): V2V_DrilldownInterface {
    if ($optionsKey === null) {
      return new V2V_Drilldown_Merge($idKey);
    }
    return new self($idKey, $optionsKey);
  }

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
