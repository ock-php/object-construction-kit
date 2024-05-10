<?php

declare(strict_types=1);

namespace Donquixote\Ock\Tests;

use Donquixote\Adaptism\UniversalAdapter\UniversalAdapterInterface;
use Donquixote\Ock\Core\Formula\FormulaInterface;
use Donquixote\Ock\Optionlessness\Optionlessness;
use Donquixote\Ock\Tests\Util\TestingServices;
use Donquixote\Ock\Tests\Util\TestUtil;
use Symfony\Component\Yaml\Yaml;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class OptionlessnessTest extends FormulaTestBase {

  /**
   * Tests various formulas.
   *
   * @param string $base
   *
   * @dataProvider providerTestFormula()
   */
  public function testFormula(string $base): void {
    $dir = dirname(__DIR__) . '/fixtures/formula';
    /** @psalm-suppress UnresolvableInclude */
    $formula = include "$dir/$base.php";
    self::assertInstanceOf(FormulaInterface::class, $formula);

    $container = TestingServices::getContainer();
    $adapter = $container->get(UniversalAdapterInterface::class);

    $optionless = Optionlessness::checkFormula($formula, $adapter);
    TestUtil::assertFileContents(
      "$dir/$base.is.optionless.yml",
      Yaml::dump($optionless),
    );
  }

}
