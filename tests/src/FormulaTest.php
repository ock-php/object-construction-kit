<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests;

use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Formula\Formula;
use Donquixote\Ock\Formula\Iface\Formula_Iface;
use Donquixote\Ock\Generator\Generator_Boolean;
use Donquixote\Ock\Generator\Generator_Drilldown;
use Donquixote\Ock\Generator\Generator_Iface;
use Donquixote\Ock\Generator\GeneratorInterface;
use Donquixote\Ock\Tests\Fixture\IntOp\IntOpInterface;
use Donquixote\Ock\Tests\Util\TestingServices;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class FormulaTest extends FormulaTestBase {

  /**
   * @throws \Donquixote\Adaptism\Exception\AdapterException
   * @throws \Donquixote\DID\Exception\ContainerToValueException
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
