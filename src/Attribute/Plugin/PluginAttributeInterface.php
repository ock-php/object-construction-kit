<?php

/**
 * @file
 */

declare(strict_types=1);

namespace Ock\Ock\Attribute\Plugin;

use Ock\Ock\Plugin\PluginDeclaration;
use Ock\Ock\Text\TextInterface;

interface PluginAttributeInterface {

  /**
   * @param \ReflectionClass $reflectionClass
   *
   * @return \Ock\Ock\Plugin\PluginDeclaration
   *
   * @throws \Ock\ClassDiscovery\Exception\MalformedDeclarationException
   * @throws \Ock\Ock\Exception\FormulaException
   * @throws \ReflectionException
   */
  public function onClass(\ReflectionClass $reflectionClass): PluginDeclaration;

  /**
   * @param \ReflectionMethod $reflectionMethod
   *
   * @return \Ock\Ock\Plugin\PluginDeclaration
   *
   * @throws \Ock\ClassDiscovery\Exception\MalformedDeclarationException
   * @throws \Ock\Ock\Exception\FormulaException
   */
  public function onMethod(\ReflectionMethod $reflectionMethod): PluginDeclaration;

  /**
   * @return string
   */
  public function getId(): string;

  /**
   * @return TextInterface
   */
  public function getLabel(): TextInterface;

}
