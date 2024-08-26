<?php

declare(strict_types=1);

namespace Ock\Ock\Tests;

use Ock\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Ock\Ock\Formula\Formula;
use Ock\Ock\Formula\Iface\Formula_Iface;
use Ock\Ock\Generator\Generator_Iface;
use Ock\Ock\Generator\GeneratorInterface;
use Ock\Ock\Tests\Fixture\IntOp\IntOpInterface;
use Ock\Ock\Tests\Util\TestingServices;

/**
 * @phpstan-suppress PropertyNotSetInConstructor
 */
class FormulaTest extends FormulaTestBase {

  /**
   * @throws \Ock\Adaptism\Exception\AdapterException
   */
  public function testFormula(): void {
    $formula = Formula::iface(IntOpInterface::class);
    self::assertInstanceOf(Formula_Iface::class, $formula);
    $adapter = TestingServices::getContainer()->get(UniversalAdapterInterface::class);
    $generator = $adapter->adapt($formula, GeneratorInterface::class);
    self::assertInstanceOf(Generator_Iface::class, $generator);
    self::assertNotSame($generator, $formula);
  }

}
