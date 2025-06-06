<?php

declare(strict_types=1);

namespace Ock\Ock\Attribute\Parameter;

use Ock\ClassDiscovery\Exception\MalformedDeclarationException;
use Ock\Ock\Attribute\PluginModifier\PluginModifierAttributeInterface;
use Ock\Ock\Contract\FormulaHavingInterface;
use Ock\Ock\Contract\LabelHavingInterface;
use Ock\Ock\Contract\NameHavingInterface;
use Ock\Ock\Core\Formula\FormulaInterface;
use Ock\Ock\Formula\ValueProvider\Formula_FixedPhp_Adaptee;
use Ock\Ock\Plugin\PluginDeclaration;
use Ock\Ock\Text\Text;
use Ock\Ock\Text\TextInterface;
use Ock\ReflectorAwareAttributes\AttributeConstructor;

#[\Attribute(\Attribute::TARGET_PARAMETER|\Attribute::TARGET_PROPERTY)]
class OckAdaptee implements NameHavingInterface, LabelHavingInterface, FormulaHavingInterface, PluginModifierAttributeInterface {

  /**
   * @var class-string
   */
  private string $type;

  public function __construct() {
    $this->type = self::guessType();
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel(): TextInterface {
    return Text::t('Adaptee');
  }

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'adaptee';
  }

  /**
   * {@inheritdoc}
   */
  public function getFormula(): FormulaInterface {
    return new Formula_FixedPhp_Adaptee();
  }

  /**
   * @return class-string
   */
  private static function guessType(): string {
    $reflector = AttributeConstructor::getReflector();
    if (!$reflector instanceof \ReflectionParameter) {
      throw new MalformedDeclarationException('This attribute must be on a parameter.');
    }
    $rt = $reflector->getType();
    if (!$rt instanceof \ReflectionNamedType || $rt->isBuiltin()) {
      throw new MalformedDeclarationException('The parameter must have a class-like type.');
    }
    $t = $rt->getName();
    if ($t === 'static' || $t === 'self') {
      $declaring_class = $reflector->getDeclaringClass();
      // These must be method parameters, if the type has 'static' or 'self'.
      assert($declaring_class !== null);
      $t = $declaring_class->getName();
    }
    /** @var class-string $t */
    return $t;
  }

  /**
   * {@inheritdoc}
   */
  public function modifyPlugin(PluginDeclaration $declaration): PluginDeclaration {
    return $declaration->withSetting('adaptee_type', $this->type);
  }

}
