<?php

declare(strict_types=1);

namespace Donquixote\Ock\Attribute\Plugin;

use Donquixote\ClassDiscovery\Exception\MalformedDeclarationException;
use Donquixote\ClassDiscovery\Util\ReflectionTypeUtil;
use Donquixote\Helpers\Util\MessageUtil;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Formula\Neutral\Formula_Passthru_FormulaFactory;
use Donquixote\Ock\Plugin\PluginDeclaration;

#[\Attribute(\Attribute::TARGET_METHOD)]
class OckPluginFormula extends PluginAttributeBase {

  /**
   * Constructor.
   *
   * @param class-string $type
   *   The instance type produced by the plugin formula.
   * @param string $id
   *   The id under which to register the plugin.
   * @param string $label
   *   Label for the plugin.
   * @param bool $translate
   *   TRUE to translate the label.
   */
  public function __construct(
    public readonly string $type,
    string $id,
    string $label,
    bool $translate = TRUE,
  ) {
    parent::__construct($id, $label, $translate);
  }

  /**
   * {@inheritdoc}
   */
  public function onClass(\ReflectionClass $reflectionClass): never {
    throw new \RuntimeException('This attribute cannot be used on a class.');
  }

  /**
   * {@inheritdoc}
   */
  public function onMethod(\ReflectionMethod $reflectionMethod): PluginDeclaration {
    if (!$reflectionMethod->isStatic()) {
      throw new MalformedDeclarationException(\sprintf(
        'Method %s must be static.',
        MessageUtil::formatReflector($reflectionMethod),
      ));
    }
    $returnClass = ReflectionTypeUtil::requireGetClassLikeType($reflectionMethod, true);
    if (!\is_a($returnClass, FormulaInterface::class, true)) {
      throw new MalformedDeclarationException(\sprintf(
        'Unexpected return type on %s.',
        MessageUtil::formatReflector($reflectionMethod),
      ));
    }
    $formula = new Formula_Passthru_FormulaFactory([
      $reflectionMethod->getDeclaringClass()->getName(),
      $reflectionMethod->getName(),
    ]);
    try {
      $rclass = new \ReflectionClass($this->type);
    }
    catch (\ReflectionException $e) {
      throw new MalformedDeclarationException($e->getMessage(), 0, $e);
    }
    return $this->formulaGetPluginDeclaration(
      $formula,
      $rclass->getInterfaceNames(),
    );
  }

}
